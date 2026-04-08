# pipe.php File

Parent: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md)

Path: `application/pipe.php`

## Purpose

This note describes the CLI-style inbound mail entry point used for ticket piping in V1.

## Use This Note When

Use this note when you need the clearest file-level answer to:

- what `application/pipe.php` does
- how inbound email becomes support tickets
- which bootstrap path differs from the normal web front controller

Do not use this note as the main owner of:

- the broader support feature set
- cron behavior in general
- the main browser request flow

## Current Behavior

`application/pipe.php` bootstraps enough of the application to accept a raw email message from `stdin` and turn it into a ticket through `tickets_model`.

In the current V1 code it:

- defines `TICKETS_PIPE`
- bootstraps the application manually instead of going through the normal web front controller
- loads hooks, the app autoloader, and core helpers
- parses inbound mail using `ZBateson\\MailMimeParser\\MailMimeParser`
- extracts the subject, sender, reply-to, recipients, body, and attachments
- optionally trims replies with `EmailReplyParser` when the related option is enabled
- normalizes the body content and attachment filenames
- passes the final payload into `tickets_model->insert_piped_ticket(...)`

## Relationship To Other Notes

- This note owns the inbound-email entry point only.
- The broader support feature area belongs in the V1 feature notes.
- Operational guidance for recurring or server-side jobs belongs in [[V1 App/Runbooks/Run Cron]].

Related: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md) | [[V1 App/Folder Reference/Folder Reference Index]] | [Folder Reference Index](Folder%20Reference%20Index.md) | [[V1 App/Runbooks/Run Cron]] | [Run Cron](../Runbooks/Run%20Cron.md)
