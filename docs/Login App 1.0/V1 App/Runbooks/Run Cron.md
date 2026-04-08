# Run Cron

Parent: [[V1 App/Runbooks/Runbook Index]] | [Runbook Index](Runbook%20Index.md)

## Purpose

Document scheduled task execution.

## Current Implementation

Perfex uses `application/application/controllers/Cron.php`. Admin Core adds interval-specific scheduler hooks such as minutely, five-minutely, hourly, daily, weekly, and monthly.

## Current Intervals

- `minutely`
- `five_minutely`
- `hourly`
- `daily`
- `weekly`
- `monthly`

## Important Notes

- Cron calls require the configured `APP_CRON_KEY` when present.
- Admin Core records last-run timestamps for interval scheduler routes.
- Events listens to minutely and five-minutely scheduler hooks.
- Weekly Admin Core scheduler currently dispatches tenant backups centrally.

## Related

- [[V1 App/Architecture/Website Sync Architecture]] | [Website Sync Architecture](../Architecture/Website%20Sync%20Architecture.md)
- [[V1 App/Modules/Events]] | [Events](../Modules/Events.md)
