# Modules Folder

Parent: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md)

Path: `application/modules/`

## Purpose

This note describes the module root folder and how V1 uses modules to segment optional or custom functionality.

## Use This Note When

Use this note when you need the clearest folder-level answer to:

- what lives in `application/modules/`
- how module packages are organized
- where custom V1 functionality tends to live first

Do not use this note as the main owner of:

- the responsibilities of individual modules
- the main app MVC flow outside modules
- feature-level behavior summaries

## Current Structure

The current repo includes module packages such as:

- `admin_core`
- `events`
- `event_photo_drop`
- `theme_style`
- `backup`
- `surveys`
- `menu_setup`
- `openai`
- other Perfex or add-on modules

Most modules follow the familiar Perfex / HMVC-style package shape with subfolders such as:

- `controllers/`
- `models/`
- `views/`
- `helpers/`
- `config/`
- `language/`
- optional `libraries/`, `assets/`, `vendor/`, or `services/`

## Relationship To Other Notes

- This note owns the folder-level view of modules as a code location.
- Individual module responsibilities belong in [[V1 App/Modules/Module Index]] and its child notes.
- Cross-cutting architecture concerns belong in the V1 architecture notes instead of being duplicated here.

Related: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md) | [[V1 App/Folder Reference/Folder Reference Index]] | [Folder Reference Index](Folder%20Reference%20Index.md) | [[V1 App/Modules/Module Index]] | [Module Index](../Modules/Module%20Index.md)
