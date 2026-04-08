# package.json File

Parent: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md)

Path: `application/package.json`

## Purpose

This note describes the Node package manifest that drives the V1 admin asset toolchain.

## Use This Note When

Use this note when you need the clearest file-level answer to:

- which NPM scripts the V1 app exposes
- which front-end build dependencies are installed
- how the main app build differs from module-specific follow-up build steps

Do not use this note as the main owner of:

- the full build pipeline behavior
- the contents of compiled output folders
- runtime UI behavior

## Current Scripts

The current script set includes:

- `dev` -> `npm run development`
- `development` -> `mix`
- `watch`
- `watch-poll`
- `hot`
- `prod` -> `npm run production`
- `production` -> `mix --production`
- `build` -> main production build, `einvoice` module build, then `node build.mjs`
- `postdev` -> `einvoice` module Mix build
- `postprod` -> `einvoice` production Mix build

## Current Dependencies

Notable toolchain dependencies include:

- `laravel-mix`
- `tailwindcss`
- `vue` and `vue-loader`
- `sass` / `sass-loader`
- `less`
- `postcss`, `autoprefixer`, `postcss-import`, and nesting plugins
- `bootstrap`
- CodeMirror packages used by parts of the admin UI

## Notes

- The build pipeline is not only for the root app; it also invokes a separate `modules/einvoice/webpack.mix.js` flow.
- The app still carries both older UI stack dependencies like Bootstrap 3 and newer tooling such as Vue 3 and Tailwind.

## Relationship To Other Notes

- This note owns the package manifest as a file-level reference.
- Overall build behavior belongs in [[V1 App/Reference/Asset Build Pipeline]].
- The main root Mix configuration belongs in [[V1 App/Folder Reference/webpack.mix.js File]].

Related: [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](Application%20Tree%20Map.md) | [[V1 App/Folder Reference/Folder Reference Index]] | [Folder Reference Index](Folder%20Reference%20Index.md) | [[V1 App/Reference/Asset Build Pipeline]] | [Asset Build Pipeline](../Reference/Asset%20Build%20Pipeline.md) | [[V1 App/Folder Reference/webpack.mix.js File]] | [webpack.mix.js File](webpack.mix.js%20File.md)
