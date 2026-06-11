# Content switcher Component API Standard

## API summary

Content switcher remains deferred until a compact peer-view switcher API is needed.

Canonical API owner: `/platform/ui-reference/components/content-switcher`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

## Status and ownership

| Field              | Value                                               |
| ------------------ | --------------------------------------------------- |
| Status             | Deferred                                            |
| API layer          | Component API                                       |
| Component slug     | content-switcher                                    |
| Category           | Navigation and disclosure                           |
| Priority           | Tier B - Common reusable component                  |
| UI Reference route | /platform/ui-reference/components/content-switcher  |
| Canonical doc      | docs/02-standards/ui/components/content-switcher.md |
| Source owner       | /platform/ui-reference/components/content-switcher  |

## Installed standard

Content switcher remains deferred until a compact peer-view switcher API is needed.

This API is not fully installed for production use. The catalog entry exists to prevent speculative local implementations and to document the gate for future work.

## Public API

| API surface     | Installed value                                                                                            |
| --------------- | ---------------------------------------------------------------------------------------------------------- |
| Blade           | No public API approved. Use Tabs for peer panel switching until this component is intentionally installed. |
| JavaScript      | No dedicated JavaScript controller required.                                                               |
| Data attributes | None approved.                                                                                             |
| Props/options   | None approved.                                                                                             |
| CSS namespace   | None approved.                                                                                             |
| Source files    | No production source files approved.                                                                       |

Example call:

```blade
{{-- No content switcher API is approved. Use x-ui.tabs for peer panel switching today. --}}
```

## Allowed variants, options, and modifiers

- None.
Deferred variants are cataloged only as future gates. Do not render unsupported variants as production UI.

## States

- Keyboard, focus, screen reader, contrast, and behavior requirements must be defined before implementation.
States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## Token, class, and helper usage

Color, Spacing, Typography, Themes, Motion, Icons, and Grid where applicable

### Foundation Elements consumed:

- Color
- Spacing
- Typography
- Themes

## Composition rules

- Use native semantics first and layer JavaScript only where behavior requires it.
- Keyboard, pointer, focus, disabled, loading, validation, overflow, and responsive behavior must match the live examples.
- Motion and state changes must use approved Foundation Motion and respect reduced-motion preferences where applicable.
Components own internal semantics and styling. Parent Patterns own grouping, external spacing, workflow orchestration, and page-level layout.

## Selection guidance

### Use when:

- Use this page to confirm the current boundary before adding the component.
### Do not use when:

- Do not build speculative UI before the trigger condition is approved.

## Accessibility contract

- Provide visible focus on every interactive element.
- Use semantic names, labels, and ARIA only where native semantics are not enough.
- Do not rely on color alone for state or meaning.
- Maintain contrast in supported light and dark themes.

## Content contract

- Use sentence case and concrete labels.
- Prefer specific nouns and verb-led action labels over vague copy.
- Keep helper, error, and status copy short enough to scan.

## Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, or custom JavaScript.
- Do not build speculative UI before the trigger condition is approved.

## Deferred or gated capabilities

- Use tabs for panel switching today.
- Trigger when a small inline mode switcher cannot use tabs.

## Implementation and UI Reference Checklist
### Implementation checklist
| Requirement                | Standard expectation                                                                                                                               |
| -------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------- |
| Public API/source          | The standard names the canonical Blade component, native/class API, JavaScript controller, CSS namespace, source files, or explicit deferred gate. |
| Variants/options/modifiers | Approved variants, options, sizes, density, layout modifiers, and deferred gates are listed.                                                       |
| States                     | Default, hover, focus-visible, active/pressed, disabled, loading, validation, selected, empty, or not-applicable states are defined as relevant.   |
| Accessibility/content      | Keyboard, focus, naming, ARIA, contrast, reduced-motion, label, helper, error, and copy requirements are defined.                                  |
| Element consumption        | Required Color, Spacing, Typography, Icons, Motion, Themes, and 2x Grid dependencies are named.                                                    |
| Tests                      | Source/API assertions and UI Reference route assertions block generic fallback content.                                                            |

### UI Reference proof checklist
| Requirement               | Visual proof expectation                                                                              |
| ------------------------- | ----------------------------------------------------------------------------------------------------- |
| Live examples             | The page renders production examples through the documented API or explicit native/class contract.    |
| Rendered variants/options | Every applicable supported variant, option, size, modifier, or deferred trigger condition is shown.   |
| Rendered states           | Required states are shown visually and with accessibility markers where relevant.                     |
| Developer implementation  | Real canonical calls and token-backed code snippets appear instead of placeholder comments.           |
| Related APIs              | Nearby Components, owning Patterns, consumed Elements, source files, and canonical docs are linked.   |
| Manual review             | The page provides enough rendered proof for visual review of behavior, layout, and state correctness. |
## UI Reference requirements

The UI Reference page must render the approved five-card scaffold: Purpose, Use cases, Component contract, Live examples, and Related components and patterns.

| Required proof     | Rendered behavior                                                                   | Variants/options shown |
| ------------------ | ----------------------------------------------------------------------------------- | ---------------------- |
| Trigger conditions | This component stays in the catalog so future work has an owner route and boundary. | Deferred, Alternative  |

## Testing and acceptance criteria

- `/platform/ui-reference/components/content-switcher` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.

## Related APIs

| API                 | Route                             |
| ------------------- | --------------------------------- |
| Components overview | /platform/ui-reference/components |

## References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)