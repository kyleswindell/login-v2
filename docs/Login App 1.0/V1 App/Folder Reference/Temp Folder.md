# Temp Folder

Parent: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md)

Path: `application/temp/`

## Purpose

This note describes the temporary runtime folder used by the V1 application.

## Use This Note When

Use this note when you need the clearest folder-level answer to:

- where transient generated files may appear
- which path `TEMP_FOLDER` resolves to in the current app
- where temporary file behavior fits in the runtime tree

Do not use this note as the main owner of:

- cache strategy as a whole
- upload storage behavior
- backup storage behavior

## Current Structure

The current repo shows only a minimal runtime placeholder:

- `application/temp/index.html`

## Notes

- `application/application/config/constants.php` defines `TEMP_FOLDER` as `FCPATH . 'temp/'`.
- The folder is expected to hold transient or generated artifacts, even if the current repo snapshot is mostly empty.

Related: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md) | [[V1 App/Folder Reference/Folder Reference Index]] | [Folder Reference Index](Folder%20Reference%20Index.md)
