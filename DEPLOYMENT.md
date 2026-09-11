# Public Deployment

This repository is prepared for a two-service deployment:

- `duty-monitoring-web`: Laravel website and API.
- `duty-monitoring-bot`: Discord worker that sends duty logs to the Laravel API.
- PostgreSQL: managed production database.

## Recommended: Render

1. Push the repository to GitHub. The repository root must contain `render.yaml`, `website-log-duty/`, and `discord-bot/`.
2. In Render, choose **New > Blueprint** and select the GitHub repository.
3. Render will create the web service, worker, and PostgreSQL database from `render.yaml`.
4. Set these values in the `duty-monitoring-web` service:

   - `APP_URL`: the public Render URL of the web service.

5. Set these values in the `duty-monitoring-bot` worker:

   - `DISCORD_TOKEN`: Discord bot token.
   - `DUTY_CHANNEL_ID`: Discord channel ID.
   - `LARAVEL_API`: `https://your-web-service.onrender.com/api/duty-logs`.

The bot token must only be entered in the provider's secret environment settings. Never commit it to GitHub.

## Local behavior

Local `php artisan serve` still starts the bot automatically. Production disables that behavior because the bot runs as its own worker:

```env
DISCORD_BOT_AUTOSTART=true
```

The production web service uses:

```env
DISCORD_BOT_AUTOSTART=false
DB_CONNECTION=pgsql
DB_URL=postgresql://...
SESSION_DRIVER=file
```

## Database migration

The web container runs this automatically on startup:

```bash
php artisan migrate --force
```

The local SQLite database is not uploaded or used by production. Existing local data must be exported and imported separately if it needs to appear online.

## Important limitation

GitHub stores the source code but does not run Laravel or the Discord bot. Render, Railway, a VPS, or another application host is required for the public website and worker.
