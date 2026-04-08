# webpack.mix.js File

Parent: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md)

Path: `application/webpack.mix.js`

## Purpose

This note describes the main Laravel Mix configuration used by the V1 application root.

## Use This Note When

Use this note when you need the clearest file-level answer to:

- what the root Mix build actually compiles and combines
- where compiled assets are written
- which post-processing steps happen in production

Do not use this note as the main owner of:

- the package dependency list
- module-specific Mix files outside the root build
- runtime asset loading behavior in individual features

## Current Build Responsibilities

The current file configures Mix to:

- compile `resources/js/app.js` into `assets/builds`
- enable Vue handling
- build Tailwind/PostCSS output from `resources/css/tailwind.css`
- combine and minify many committed vendor/admin JS assets into files like:
  - `assets/builds/vendor-admin.js`
  - `assets/builds/common.js`
  - `assets/builds/bootstrap-select.min.js`
  - `assets/builds/moment.min.js`
- combine vendor/admin CSS into `assets/builds/vendor-admin.css`
- minify several existing shipped CSS and JS files

## Output And Rewrite Behavior

- `processCssUrls` is disabled by default
- source maps are disabled
- notifications are disabled
- a webpack replace plugin rewrites asset paths inside compiled CSS so referenced plugin images/fonts resolve correctly

## Production Behavior

When Mix runs in production, the file also:

- reads the Perfex migration config version from `application/config/migration.php`
- prepends that version string as a header comment into selected minified JS files

## Relationship To Other Notes

- This note owns the root Mix file as a file-level reference.
- Package scripts and dependency ownership belong in [[V1 App/Folder Reference/package.json File]].
- The broader build process belongs in [[V1 App/Reference/Asset Build Pipeline]].

Related: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md) | [[V1 App/Folder Reference/Folder Reference Index]] | [Folder Reference Index](Folder%20Reference%20Index.md) | [[V1 App/Reference/Asset Build Pipeline]] | [Asset Build Pipeline](../Reference/Asset%20Build%20Pipeline.md) | [[V1 App/Folder Reference/package.json File]] | [package.json File](package.json%20File.md) | [[V1 App/Folder Reference/Resources Folder]] | [Resources Folder](Resources%20Folder.md)
