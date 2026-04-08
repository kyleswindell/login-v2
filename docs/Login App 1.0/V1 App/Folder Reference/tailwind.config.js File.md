# tailwind.config.js File

Parent: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md)

Path: `application/tailwind.config.js`

## Purpose

This note describes the Tailwind configuration used by the V1 root asset build.

## Use This Note When

Use this note when you need the clearest file-level answer to:

- which files Tailwind scans for class usage
- why Tailwind classes in V1 use a prefix
- which theme and safety settings shape generated utilities

Do not use this note as the main owner of:

- the full Mix build behavior
- NPM dependency ownership
- runtime CSS loading behavior

## Current Behavior

The current config:

- scans PHP views under `application/views/` and module views under `modules/**/views/`
- scans selected shipped JS files under `assets/js/`
- scans Vue component source under `resources/js/**/*.vue`
- uses the `tw-` prefix for generated utilities
- disables `preflight`
- includes a broad safelist pattern for classes that may be generated or composed dynamically

## Theme Notes

- the theme extends font sizes and adds a `spin-slow` animation
- color aliases map Tailwind color groups into names such as `danger`, `warning`, `success`, `info`, and `primary`

## Relationship To Other Notes

- This note owns the Tailwind config file as a file-level reference.
- The broader asset pipeline belongs in [[V1 App/Reference/Asset Build Pipeline]].
- The authored source side of the build belongs in [[V1 App/Folder Reference/Resources Folder]].

Related: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md) | [[V1 App/Folder Reference/Folder Reference Index]] | [Folder Reference Index](Folder%20Reference%20Index.md) | [[V1 App/Reference/Asset Build Pipeline]] | [Asset Build Pipeline](../Reference/Asset%20Build%20Pipeline.md) | [[V1 App/Folder Reference/Resources Folder]] | [Resources Folder](Resources%20Folder.md)
