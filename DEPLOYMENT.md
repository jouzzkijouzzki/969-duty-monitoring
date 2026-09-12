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

## Railway / Railpack

Railway must create two services from this monorepo. The repository root is not an application, so do not deploy it with `/` as the service root.

Create the services with these settings:

| Service | Root Directory | Builder |
| --- | --- | --- |
| Web | `/website-log-duty` | Dockerfile |
| Discord bot | `/discord-bot` | Dockerfile |

Both folders contain a `railway.json` that selects Dockerfile builds. If Railway still shows Railpack analyzing the repository root, open the service's **Settings > Source** and set its Root Directory before redeploying.

Note: `website-log-duty` is a separate nested Git repository in this workspace. Commit and push its `railway.json` to the website repository first, then commit the updated website pointer in the parent repository. The parent repository must point to the commit that contains this file.

For the web service, configure `APP_KEY`, `APP_URL`, `APP_ENV=production`, `APP_DEBUG=false`, and the PostgreSQL variables (`DB_CONNECTION=pgsql`, `DB_URL`). The container listens on Railway's `PORT` automatically and exposes `/up` as its health check.

For the bot service, configure `DISCORD_TOKEN`, `DUTY_CHANNEL_ID`, and `LARAVEL_API` with the web service URL, for example `https://your-web-service.up.railway.app/api/duty-logs`.

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
