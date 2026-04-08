# Events Data Model

Parent: [[V1 App/Reference Index]] | [Reference Index](../Reference%20Index.md)

## Summary

The Events module stores event records, public photo-drop uploads, sponsors, and blocked submitters. Its install file is idempotent and also includes legacy rename support from `event_photo_drop`.

## Main Tables

### `tblevents_events`

Stores event records and website publishing state.

Important fields include:

- `name`
- `event_type`
- `status`
- `collection_mode`
- `description`
- `internal_notes`
- `location`
- `image_file_name`
- `event_color`
- `event_date`
- `start_at`
- `end_at`
- `all_day`
- `duration_minutes`
- `recurrence`
- `recur_every`
- `recur_weekdays`
- `recurrence_end_type`
- `recurrence_end_date`
- `recurrence_end_occurrences`
- `public_token`
- `short_public_code`
- `photo_drop_enabled`
- `allow_multiple_submissions`
- `max_files_per_submission`
- `show_sponsors_on_slideshow`
- `rotate_photo_drop_token_each_occurrence`
- `token_occurrence_sequence`
- `sponsors_enabled`
- `public_visibility`
- `publish_to_website`
- `website_slug`
- `website_last_synced_at`
- `perfex_event_id`

### `tblevents_uploads`

Stores public photo-drop submissions and moderation state.

Important fields include:

- `event_id`
- `submission_token`
- `occurrence_sequence`
- `occurrence_start_at`
- `submitter_fingerprint`
- `first_name`
- `last_name`
- `email`
- `phone`
- `description`
- `original_file_name`
- `stored_file_name`
- `file_ext`
- `file_mime`
- `file_size`
- `is_active`
- `review_status`
- `is_inappropriate`
- `moderation_note`

### `tblevents_sponsors`

Stores event sponsor entries and optional logos.

Important fields include:

- `event_id`
- `name`
- `website_url`
- `logo_file_name`
- `sort_order`
- `is_active`

### `tblevents_blocked_submitters`

Stores blocked submitter fingerprints.

Important fields include:

- `submitter_fingerprint`
- `is_active`
- `reason`
- `blocked_by`
- `blocked_at`

## Options

- `events_website_sync_enabled`
- `events_website_sync_dir`
- `events_website_channels`

## Legacy Compatibility

The install routine can rename legacy `event_photo_drop` tables/options/module records to Events equivalents where applicable.

## Related

- [[V1 App/Modules/Events]] | [Events](../Modules/Events.md)
- [[V1 App/Reference/Database Schema And Relationships]] | [Database Schema And Relationships](Database%20Schema%20And%20Relationships.md)
- [[V1 App/Features/Event Website Sync]] | [Event Website Sync](../Features/Event%20Website%20Sync.md)
- [[Standards/Database Migration Standards]] | [Database Migration Standards](../../Standards/Database%20Migration%20Standards.md)
