---
title: Carbon UI Provenance
slug: carbon-ui-provenance
status: support-reference
api_layer: Support documentation
source_reference: reference/carbon-main
---

# Carbon UI Provenance

## Purpose

This support reference maps the current Login App UI source files back to the
local Carbon reference checkout by file name, package ownership, and source
surface. It is an inventory for later cleanup, rendered-evidence review, and
agent-governance review.

This is not a component quality audit, visual parity review, API review, or
permission to edit UI source files.

## Artifacts

| Artifact | Purpose |
| --- | --- |
| [Carbon Package Overview](carbon-package-overview.md) | High-level package map for `reference/carbon-main/packages`. |
| [CSS Source Map](css-source-map.md) | Canonical component CSS mapped to Carbon SCSS component owners. |
| [Blade Source Map](blade-source-map.md) | Canonical Blade components mapped to Carbon React component owners. |
| [JS Source Map](js-source-map.md) | Canonical UI JavaScript mapped to Carbon React behavior owners where applicable. |
| [Primitive Source Map](primitive-source-map.md) | `tokens`, `base`, and `type` CSS mapped to Carbon primitive/style owners. |
| [Carbon React Test Alignment](carbon-react-test-alignment.md) | Carbon React test inventory mapped to co-located Login App UI test targets. |
| [Carbon Test Coverage Matrix](carbon-test-coverage-matrix.md) | Carbon-wide React component and foundation package test matrix with local test creation instructions. |

## Scope

Included surfaces:

- `resources/css/components/*.css`
- `resources/css/components/ui-shell/*.css`
- `resources/views/components/ui/*.blade.php`
- `resources/js/app.js`
- `resources/js/ui-controls.js`
- `resources/js/ui-controls/*.js`
- `resources/css/tokens/**/*.css`
- `resources/css/base/*.css`
- `resources/css/type/*.css`

Excluded surfaces:

- `docs/_archive/`
- `resources/css/components/ui-shell-backup-*`
- `resources/css/components/*.backup.css`
- `resources/css/backup-app.css`
- `resources/css/legacy.css`
- `resources/css/reference/*`
- generated icon SVG payloads under `resources/views/components/icons/`
- retired reference viewer pages under `resources/viewsnot installed/`
- vendor, package manager, and build output files
- copied scratch files such as `overview.blade copy.php`

## Classification Legend

| Classification | Meaning |
| --- | --- |
| `direct` | Local file has a direct Carbon source owner by name or component role. |
| `integrated-fluid` | Local file maps to a Carbon `fluid-*` source or folded fluid variant. |
| `compatibility` | Local file bridges app naming, Blade structure, aliases, or split files over Carbon-owned behavior. |
| `app-semantic` | Local file expresses an app-owned semantic concept using Carbon primitives or components. |
| `base-owned` | Local file belongs to the app base/primitive layer rather than a component layer. |
| `no-carbon-equivalent` | No meaningful Carbon source owner is implied by file name or role. |

## Review Depth

This pass is filename-oriented. It compares local filenames, Carbon package
directories, and obvious source ownership. It does not inspect implementation
parity unless a filename relation is ambiguous.

Later rendered-evidence and visual review should verify:

- component anatomy;
- public Blade props and slots;
- ARIA, keyboard, and focus behavior;
- motion and state behavior;
- rendered visual parity against the intended app standard.

## Next Gates

1. Complete UI source cleanup and decide which transitional files remain
   canonical.
2. Define the replacement rendered-evidence surface from the accepted component set.
3. Run visual/API review against the replacement rendered-evidence surface.
4. Review and update root/nested `AGENTS.md` and `.agents/skills/*` in a
   separate governance pass using this provenance inventory as context.
