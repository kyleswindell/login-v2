# Events Routes

Parent: [[V1 App/Reference Index]] | [Reference Index](../Reference%20Index.md)

## Summary

The Events module defines admin routes, public upload portal routes, and legacy `event_photo_drop` aliases.

## Public Routes

- `events/public_portal/submitted/{token}`
- `events/public_portal/{token}`
- `events/p/{short_code}`
- `event_photo_drop/public_portal/submitted/{token}`
- `event_photo_drop/public_portal/{token}`
- `event_photo_drop/p/{short_code}`

## Admin Routes

- `admin/events`
- `admin/events/channel/{channel}`
- `admin/events/new`
- `admin/events/new_channel/{channel}`
- `admin/events/collections`
- `admin/events/new_collection`
- `admin/events/sync_all_website`
- `admin/events/settings`
- `admin/events/blocked_submitters`
- `admin/events/{id}`
- `admin/events/sponsors/{event_id}`

## AJAX / Action Routes

- `admin/events/update_features/{id}`
- `admin/events/preview_items/{id}`
- `admin/events/submissions_data/{id}`
- `admin/events/submission_details/{id}`
- `admin/events/next_unreviewed/{id}`
- `admin/events/review_upload/{upload_id}`
- `admin/events/update_upload_description/{upload_id}`
- `admin/events/flag_upload_inappropriate/{upload_id}`
- `admin/events/clear_upload_inappropriate/{upload_id}`

## CSRF Exclusions

Public portal upload routes are excluded from CSRF by module config:

- `events/public_portal/.+`
- `event_photo_drop/public_portal/.+`

## Related

- [[V1 App/Modules/Events]] | [Events](../Modules/Events.md)
- [[V1 App/Reference/Events Data Model]] | [Events Data Model](Events%20Data%20Model.md)
- [[Standards/Security Standards]] | [Security Standards](../../Standards/Security%20Standards.md)
