---
title: Primitive Source Map
slug: primitive-source-map
status: support-reference
api_layer: Support documentation
source_reference: reference/carbon-main/packages
---

# Primitive Source Map

## Scope

This map covers:

- `resources/css/tokens/**/*.css`
- `resources/css/base/*.css`
- `resources/css/type/*.css`

Primitive files are mapped to Carbon primitive/style package owners by filename
and role. They are not component implementation maps.

## Token CSS

| Local CSS                                              | Carbon source owner                        | Classification         | Notes                                                |
| ------------------------------------------------------ | ------------------------------------------ | ---------------------- | ---------------------------------------------------- |
| `resources/css/tokens/components/buttons.css`          | `styles/scss/components/button/`           | `direct`               | Component token owner for Button.                    |
| `resources/css/tokens/components/content-switcher.css` | `styles/scss/components/content-switcher/` | `direct`               | Component token owner for ContentSwitcher.           |
| `resources/css/tokens/components/index.css`            | None                                       | `no-carbon-equivalent` | App component-token entrypoint.                      |
| `resources/css/tokens/components/notifications.css`    | `styles/scss/components/notification/`     | `direct`               | Component token owner for Notification.              |
| `resources/css/tokens/components/status.css`           | indicators, tags, notifications            | `app-semantic`         | App status token abstraction.                        |
| `resources/css/tokens/components/tags.css`             | `styles/scss/components/tag/`              | `direct`               | Component token owner for Tag.                       |
| `resources/css/tokens/index.css`                       | None                                       | `no-carbon-equivalent` | App token entrypoint.                                |
| `resources/css/tokens/layout.css`                      | `layout/`, `grid/`                         | `direct`               | Layout primitive owner.                              |
| `resources/css/tokens/motion.css`                      | `motion/`                                  | `direct`               | Motion primitive owner.                              |
| `resources/css/tokens/palette/base-colors.css`         | `colors/`                                  | `direct`               | Carbon color palette owner.                          |
| `resources/css/tokens/palette/index.css`               | `colors/`                                  | `direct`               | Palette entrypoint over Carbon color owner.          |
| `resources/css/tokens/semantic/app-aliases.css`        | themes, components                         | `app-semantic`         | App semantic aliases over Carbon roles.              |
| `resources/css/tokens/semantic/index.css`              | None                                       | `no-carbon-equivalent` | App semantic-token entrypoint.                       |
| `resources/css/tokens/shadow.css`                      | layout/style primitives                    | `app-semantic`         | App shadow primitive; no direct package name match.  |
| `resources/css/tokens/spacing.css`                     | `layout/`                                  | `direct`               | Carbon spacing/layout primitive owner.               |
| `resources/css/tokens/themes/forced-colors.css`        | `themes/`                                  | `direct`               | Forced-colors theme support.                         |
| `resources/css/tokens/themes/gray-10.css`              | `themes/`                                  | `direct`               | Carbon theme role owner.                             |
| `resources/css/tokens/themes/gray-100.css`             | `themes/`                                  | `direct`               | Carbon theme role owner.                             |
| `resources/css/tokens/themes/gray-90.css`              | `themes/`                                  | `direct`               | Carbon theme role owner.                             |
| `resources/css/tokens/themes/index.css`                | `themes/`                                  | `direct`               | Theme entrypoint over Carbon theme owner.            |
| `resources/css/tokens/themes/white.css`                | `themes/`                                  | `direct`               | Carbon theme role owner.                             |
| `resources/css/tokens/type/index.css`                  | `type/`                                    | `direct`               | Token bridge to app type layer.                      |
| `resources/css/tokens/z-index.css`                     | layout/style primitives                    | `app-semantic`         | App z-index primitive; no direct package name match. |

## Base CSS

| Local CSS                                      | Carbon source owner                       | Classification         | Notes                                                     |
| ---------------------------------------------- | ----------------------------------------- | ---------------------- | --------------------------------------------------------- |
| `resources/css/base/animation.css`             | `motion/`, component keyframes            | `base-owned`           | Shared animation/keyframe primitive owner.                |
| `resources/css/base/aspect-ratio.css`          | `styles/scss/components/aspect-ratio/`    | `base-owned`           | Carbon component source is owned locally as base utility. |
| `resources/css/base/compatibility.css`         | None                                      | `compatibility`        | App compatibility bridge.                                 |
| `resources/css/base/component-reset.css`       | reset/style primitives                    | `base-owned`           | Shared component reset owner.                             |
| `resources/css/base/control-reset.css`         | form/reset primitives                     | `base-owned`           | Shared control reset owner.                               |
| `resources/css/base/document.css`              | `themes/`, style primitives               | `base-owned`           | Document-level theme application.                         |
| `resources/css/base/field-layer.css`           | form, layer, themes                       | `base-owned`           | Shared field/layer primitive.                             |
| `resources/css/base/focus.css`                 | style primitives                          | `base-owned`           | Shared focus primitive.                                   |
| `resources/css/base/forced-colors.css`         | `themes/`                                 | `base-owned`           | Forced-colors base behavior.                              |
| `resources/css/base/grid.css`                  | `grid/`                                   | `base-owned`           | Grid primitive owner.                                     |
| `resources/css/base/index.css`                 | None                                      | `no-carbon-equivalent` | App base CSS entrypoint.                                  |
| `resources/css/base/layer.css`                 | `themes/`, `react/Layer`                  | `base-owned`           | Layer primitive owner.                                    |
| `resources/css/base/layout-context.css`        | `layout/`                                 | `base-owned`           | Layout context primitive.                                 |
| `resources/css/base/reset.css`                 | reset/style primitives                    | `base-owned`           | Shared reset owner.                                       |
| `resources/css/base/responsive-visibility.css` | `grid/`, `layout/`                        | `base-owned`           | Responsive visibility primitive.                          |
| `resources/css/base/shadow.css`                | style primitives                          | `base-owned`           | Shared shadow primitive.                                  |
| `resources/css/base/skeleton.css`              | `styles/scss/components/skeleton-styles/` | `base-owned`           | Shared skeleton primitive.                                |
| `resources/css/base/state.css`                 | None                                      | `base-owned`           | App shared state primitive.                               |
| `resources/css/base/text-overflow.css`         | style utilities                           | `base-owned`           | Shared text overflow primitive.                           |
| `resources/css/base/transform.css`             | None                                      | `base-owned`           | App transform utility primitive.                          |
| `resources/css/base/typography.css`            | `type/`                                   | `base-owned`           | Document/base typography application.                     |
| `resources/css/base/visually-hidden.css`       | style/accessibility primitives            | `base-owned`           | Shared accessibility utility.                             |

## Type CSS

| Local CSS                            | Carbon source owner | Classification | Notes                                       |
| ------------------------------------ | ------------------- | -------------- | ------------------------------------------- |
| `resources/css/type/fluid.css`       | `type/`             | `direct`       | Fluid type primitive owner.                 |
| `resources/css/type/font-family.css` | `type/`             | `direct`       | Font-family primitive owner.                |
| `resources/css/type/font-weight.css` | `type/`             | `direct`       | Font-weight primitive owner.                |
| `resources/css/type/index.css`       | `type/`             | `direct`       | App type entrypoint over Carbon type owner. |
| `resources/css/type/print.css`       | `type/`             | `direct`       | Print type primitive owner.                 |
| `resources/css/type/reset.css`       | `type/`             | `direct`       | Type reset owner.                           |
| `resources/css/type/scale.css`       | `type/`             | `direct`       | Type scale primitive owner.                 |
| `resources/css/type/styles.css`      | `type/`             | `direct`       | Type style primitive owner.                 |
| `resources/css/type/tokens.css`      | `type/`             | `direct`       | Type token primitive owner.                 |
| `resources/css/type/types.css`       | `type/`             | `direct`       | Type helper class owner.                    |

## Notes For Later Review

- Component CSS should consume token/base/type primitives rather than defining
  raw color, type, spacing, or reset behavior locally.
- Files classified `app-semantic` are acceptable support surfaces only if later
  standards or rendered evidence review preserve them intentionally.
- `base-owned` means the local file is intentionally outside component CSS even
  when the nearest Carbon source is a component SCSS folder.
