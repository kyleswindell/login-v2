# Resources Folder

Parent: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md)

Path: `application/resources/`

## Purpose

This note describes the source-asset tree used by the V1 build pipeline.

## Use This Note When

Use this note when you need the clearest folder-level answer to:

- where editable front-end source assets live before compilation
- which subfolders feed the root Mix/Tailwind pipeline
- how `resources/` differs from shipped output under `assets/`

Do not use this note as the main owner of:

- runtime compiled asset outputs
- package script definitions
- feature behavior that consumes built assets

## Current Structure

The current repo shows a small source tree:

- `resources/css/`
- `resources/js/`
- `resources/js/components/`
- `resources/js/components/filters/`

## Notes

- `resources/js/app.js` is the main JavaScript entry consumed by `webpack.mix.js`.
- `resources/js/components/filters/` contains Vue component source used by the admin UI.
- `resources/css/tailwind.css` is the Tailwind/PostCSS source entry compiled into `assets/builds`.
- This folder is the authored source side of the asset pipeline; runtime delivery happens from `application/assets/`.

## Relationship To Other Notes

- This note owns the source-asset folder as a code location.
- Runtime asset delivery belongs in [[V1 App/Folder Reference/Assets Folder]].
- Build behavior belongs in [[V1 App/Reference/Asset Build Pipeline]] and the file notes for `package.json`, `webpack.mix.js`, and `tailwind.config.js`.

Related: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md) | [[V1 App/Folder Reference/Folder Reference Index]] | [Folder Reference Index](Folder%20Reference%20Index.md) | [[V1 App/Reference/Asset Build Pipeline]] | [Asset Build Pipeline](../Reference/Asset%20Build%20Pipeline.md) | [[V1 App/Folder Reference/Assets Folder]] | [Assets Folder](Assets%20Folder.md)
