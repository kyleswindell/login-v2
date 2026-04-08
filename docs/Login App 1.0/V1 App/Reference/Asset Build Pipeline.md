# Asset Build Pipeline

Parent: [[V1 App/Reference Index]] | [Reference Index](../Reference%20Index.md)

## Summary

The admin app uses a Node/Laravel Mix asset pipeline with Vue 3, Tailwind, Sass/Less tooling, PostCSS, and Bootstrap 3 assets.

## Important Files

- `application/package.json`
- `application/webpack.mix.js`
- `application/tailwind.config.js`
- `application/resources/js/app.js`
- `application/resources/js/components/filters/*.vue`
- `application/resources/css/tailwind.css`

## Current Scripts

Run from `application/`.

```bash
npm run dev
npm run watch
npm run prod
npm run build
```

## Current Notes

- Vue is used for selected components, currently including app filters.
- Tailwind uses the `tw-` prefix to reduce collisions with Perfex/Bootstrap CSS.
- Tailwind preflight is disabled.
- Compiled outputs are written under `application/assets/builds`.
- Bootstrap 3 is still part of the admin UI asset stack.

## Related

- [[V1 App/Runbooks/Build Assets]] | [Build Assets](../Runbooks/Build%20Assets.md)
- [[V1 App/Folder Reference/package.json File]] | [package.json File](../Folder%20Reference/package.json%20File.md)
- [[V1 App/Folder Reference/webpack.mix.js File]] | [webpack.mix.js File](../Folder%20Reference/webpack.mix.js%20File.md)
