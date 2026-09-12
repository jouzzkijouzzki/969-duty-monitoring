require('dotenv').config();
const axios = require('axios');

const {
    Client,
    GatewayIntentBits
} = require('discord.js');

const client = new Client({
    intents: [
        GatewayIntentBits.Guilds,
        GatewayIntentBits.GuildMessages,
        GatewayIntentBits.MessageContent
    ]
});

function normalizeKey(value) {
    return String(value).toLowerCase().replace(/[^a-z0-9]/g, '');
}

function parseMinutes(value) {
    if (value === null || value === undefined || value === '') return null;

    const text = String(value).trim().toLowerCase();
    const clockMatch = text.match(/^(\d+):([0-5]\d)(?::([0-5]\d))?$/);
    if (clockMatch) {
        return Number.parseInt(clockMatch[1], 10) * 60 + Number.parseInt(clockMatch[2], 10);
    }

    const days = Number.parseInt(text.match(/(\d+)\s*(?:hari|day|days|d)\b/)?.[1] || '0', 10);
    const hours = Number.parseInt(text.match(/(\d+)\s*(?:jam|hour|hours|h)\b/)?.[1] || '0', 10);
    const minutes = Number.parseInt(text.match(/(\d+)\s*(?:menit|minute|minutes|min|m)\b/)?.[1] || '0', 10);
    if (days || hours || minutes) return days * 24 * 60 + hours * 60 + minutes;

    const number = Number.parseInt(text.replace(/[^0-9-]/g, ''), 10);
    return Number.isNaN(number) ? null : number;
}

function parseDate(value) {
    if (!value) return null;

    const text = String(value).trim();
    const localMatch = text.match(/^(\d{1,2})[/-](\d{1,2})[/-](\d{4})(?:\s+(\d{1,2})[:.]([0-5]\d)(?::([0-5]\d))?)?$/);

    if (localMatch) {
        const [, day, month, year, hour = '00', minute = '00', second = '00'] = localMatch;
        return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')} ${hour.padStart(2, '0')}:${minute}:${second}`;
    }

    const date = new Date(text);
    return Number.isNaN(date.getTime()) ? null : date.toISOString().slice(0, 19).replace('T', ' ');
}

function getApiUrl() {
    const apiUrl = process.env.LARAVEL_API?.trim();
    if (!apiUrl) {
        console.error('❌ Error konfigurasi: LARAVEL_API belum diatur.');
        return null;
    }

    try {
        const url = new URL(apiUrl);
        if (!['http:', 'https:'].includes(url.protocol)) throw new Error('protocol tidak didukung');
        return url.toString();
    } catch (error) {
        console.error(`❌ Error konfigurasi: LARAVEL_API tidak valid (${error.message}).`);
        return null;
    }
}

function wait(milliseconds) {
    return new Promise(resolve => setTimeout(resolve, milliseconds));
}

function isRetryableError(error) {
    return !error.response || error.response.status >= 500;
}

function getMessageValues(message) {
    const values = new Map();

    for (const embed of message.embeds) {
        for (const field of embed.fields) {
            values.set(normalizeKey(field.name), field.value.trim());
        }

        if (embed.description) {
            for (const line of embed.description.split(/\r?\n/)) {
                const match = line.match(/^\s*([^:]+):\s*(.+)$/);
                if (match) values.set(normalizeKey(match[1]), match[2].trim());
            }
        }
    }

    for (const line of message.content.split(/\r?\n/)) {
        const match = line.match(/^\s*([^:]+):\s*(.+)$/);
        if (match) values.set(normalizeKey(match[1]), match[2].trim());
    }

    return values;
}

function firstValue(values, keys) {
    return keys.map(normalizeKey).map(key => values.get(key)).find(Boolean) || null;
}

function extractDiscordId(value) {
    if (!value) return null;

    const text = String(value);
    const mention = text.match(/<@!?(\d{17,20})>/);
    if (mention) return mention[1];

    const id = text.match(/\b\d{17,20}\b/);
    return id ? id[0] : null;
}

function cleanPlayerName(value) {
    if (!value) return null;

    return String(value)
        .replace(/<@!?\d{17,20}>/g, '')
        .replace(/[\*_`]/g, '')
        .trim() || null;
}

function cleanFieldValue(value) {
    if (!value) return null;

    return String(value).replace(/[\*_`]/g, '').trim() || null;
}

function parseDutyLog(message) {
    const values = getMessageValues(message);
    const dutyStartEmbed = message.embeds.find(embed => /going on duty/i.test(embed.title || ''));
    const playerValue = firstValue(values, ['player name', 'player', 'nama player', 'nama', 'user', 'member']);
    const playerName = cleanPlayerName(playerValue)
        || cleanPlayerName(dutyStartEmbed?.title?.replace(/\s*\|\s*going on duty\s*$/i, ''));

    if (!playerName) return null;

    const statusValue = firstValue(values, ['status', 'state']);
    const status = dutyStartEmbed || (statusValue && /on.?duty|aktif|mulai/i.test(statusValue))
        ? 'on_duty'
        : 'off_duty';
    const discordId = extractDiscordId(firstValue(values, ['discord id', 'discord', 'id discord', 'user id', 'member id']))
        || extractDiscordId(playerValue)
        || message.mentions?.users?.first()?.id
        || null;

    const startDate = parseDate(firstValue(values, ['start date', 'start', 'mulai', 'waktu mulai', 'jam masuk', 'duty start']));
    const endDate = parseDate(firstValue(values, ['end date', 'end', 'selesai', 'waktu selesai', 'jam keluar', 'duty end']));
    const durationValue = firstValue(values, [
        'duration', 'durasi', 'durasi duty', 'lama duty', 'duty duration',
        'total duty', 'jam duty', 'waktu duty', 'lama kerja'
    ]);
    let duration = parseMinutes(durationValue);

    if (duration === null && startDate && endDate) {
        duration = Math.max(0, Math.round((Date.parse(endDate) - Date.parse(startDate)) / 60000));
    }

    return {
        player_name: playerName,
        discord_id: discordId,
        license: cleanFieldValue(firstValue(values, ['license', 'rockstar license', 'steam'])),
        shift: firstValue(values, ['shift', 'divisi', 'department']),
        duration: duration ?? 0,
        start_date: startDate,
        end_date: endDate,
        total_mingguan: parseMinutes(firstValue(values, [
            'total mingguan', 'weekly total', 'total duty mingguan', 'weekly duty', 'total'
        ])) ?? 0,
        status,
        discord_message_id: message.id,
    };
}

async function syncMessage(message) {
    const dutyLog = parseDutyLog(message);
    if (!dutyLog) return 'invalid';

    const apiUrl = getApiUrl();
    if (!apiUrl) return 'failed';

    for (let attempt = 1; attempt <= 3; attempt++) {
        try {
            await axios.post(apiUrl, dutyLog, {
                timeout: 10000,
                headers: { Accept: 'application/json' },
            });
            const action = dutyLog.status === 'on_duty' ? 'masuk' : 'selesai';
            console.log(`✅ Duty ${action}: ${dutyLog.player_name}`);
            return 'saved';
        } catch (error) {
            if (!isRetryableError(error) || attempt === 3) {
                const detail = error.response?.data?.message
                    || (error.response?.data?.errors && JSON.stringify(error.response.data.errors))
                    || error.message;
                console.error(`❌ Error database untuk ${dutyLog.player_name}: ${detail}`);
                return 'failed';
            }

            await wait(attempt * 2000);
        }
    }
}

async function getStoredMessageIds() {
    const apiUrl = getApiUrl();
    if (!apiUrl) return null;

    for (let attempt = 1; attempt <= 6; attempt++) {
        try {
            const response = await axios.get(apiUrl, {
                params: { message_ids: 1 },
                timeout: 10000,
                headers: { Accept: 'application/json' },
            });

            return new Set(response.data?.data || []);
        } catch (error) {
            if (!isRetryableError(error) || attempt === 6) {
                const detail = error.response?.data?.message || error.message;
                console.error(`❌ Error database saat membaca log tersimpan: ${detail}`);
                return null;
            }

            await wait(Math.min(attempt * 5000, 15000));
        }
    }
}

client.once('ready', async () => {
    console.log(`✅ Bot online: ${client.user.tag}`);

    try {
        const channel = await client.channels.fetch(
            process.env.DUTY_CHANNEL_ID
        );

        if (!channel) {
            console.error('❌ Error Discord: channel tidak ditemukan.');
            return;
        }

        const cutoffDate = new Date(Date.now() - 8 * 24 * 60 * 60 * 1000);
        const storedMessageIds = await getStoredMessageIds();
        if (!storedMessageIds) return;

        let lastId = null;
        let totalPesan = 0;
        let skippedPesan = 0;
        let savedPesan = 0;
        let invalidPesan = 0;
        let failedPesan = 0;
        let reachedCutoff = false;

        while (true) {
            const options = {
                limit: 100
            };

            if (lastId) {
                options.before = lastId;
            }

            const messages = await channel.messages.fetch(options);

            if (messages.size === 0) {
                break;
            }

            for (const message of messages.values()) {
                if (message.createdAt < cutoffDate) {
                    reachedCutoff = true;
                    break;
                }

                totalPesan++;
                if (storedMessageIds.has(message.id)) {
                    skippedPesan++;
                    continue;
                }

                const result = await syncMessage(message);
                if (result === 'saved') {
                    storedMessageIds.add(message.id);
                }
                if (result === 'invalid') invalidPesan++;
                if (result === 'saved') savedPesan++;
                if (result === 'failed') failedPesan++;
            }

            if (reachedCutoff) {
                break;
            }

            lastId = messages.last().id;

            if (messages.size < 100) {
                break;
            }
        }

        console.log(`✅ Sinkronisasi selesai: ${totalPesan} diperiksa, ${savedPesan} tersimpan, ${skippedPesan} sudah tercatat, ${invalidPesan} format dilewati, ${failedPesan} gagal.`);

    } catch (error) {
        console.error('❌ Error Discord saat membaca channel:');
        console.error(error);
    }
});

client.on('messageCreate', async (message) => {
    if (message.channel.id !== process.env.DUTY_CHANNEL_ID) {
        return;
    }

    try {
        await syncMessage(message);
    } catch (error) {
        console.error('❌ Error Discord saat memproses pesan baru:');
        console.error(error);
    }
});

if (require.main === module) {
    if (!process.env.DISCORD_TOKEN || !process.env.DUTY_CHANNEL_ID) {
        console.error('❌ Error konfigurasi: DISCORD_TOKEN dan DUTY_CHANNEL_ID wajib diatur.');
        process.exitCode = 1;
    } else {
        client.login(process.env.DISCORD_TOKEN);
    }
}

module.exports = { parseDutyLog, parseMinutes, parseDate };