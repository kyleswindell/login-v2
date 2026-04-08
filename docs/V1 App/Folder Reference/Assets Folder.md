# Assets Folder

Parent: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md)

Path: `application/assets/`

## Purpose

This note describes the runtime-facing asset tree used by the V1 admin application and related Perfex UI surfaces.

## Use This Note When

Use this note when you need the clearest folder-level answer to:

- what `application/assets/` actually contains
- where compiled outputs land after the build pipeline runs
- which vendor/plugin assets are shipped directly from the repo

Do not use this note as the main owner of:

- the build pipeline logic itself
- source asset authoring under `application/resources/`
- feature behavior that happens to load these assets

## Current Structure

Key top-level areas in the current repo include:

- `assets/builds/`: compiled outputs such as bundled JS, CSS, and combined vendor assets
- `assets/css/`: shipped stylesheet files
- `assets/js/`: shipped application JavaScript files
- `assets/images/`: image assets, including MIME icon assets
- `assets/plugins/`: third-party UI and utility packages such as jQuery, Bootstrap, DataTables, Dropzone, TinyMCE, Lightbox, Chart.js, Moment, and internal plugin bundles
- `assets/themes/`: theme-specific assets, including the `perfex` theme

## Notes

- This folder mixes committed vendor/static assets with build outputs.
- `webpack.mix.js` writes compiled files into `assets/builds/`.
- The admin UI still depends on a Bootstrap 3 era asset stack even though Vue 3 and Tailwind are also present in the build process.

## Relationship To Other Notes

- This note owns the runtime asset folder as a code location.
- Build scripts and pipeline behavior belong in [[V1 App/Reference/Asset Build Pipeline]].
- Source asset authoring belongs more closely with [[V1 App/Folder Reference/Resources Folder]].

Related: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md) | [[V1 App/Folder Reference/Folder Reference Index]] | [Folder Reference Index](Folder%20Reference%20Index.md) | [[V1 App/Reference/Asset Build Pipeline]] | [Asset Build Pipeline](../Reference/Asset%20Build%20Pipeline.md)
