<?php

namespace App\Platform\UiReference;

class UiReferenceElementCatalog
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function all(): array
    {
        return $this->elements();
    }

    /**
     * @return array<string, mixed>|null
     */
    public function find(string $slug): ?array
    {
        foreach ($this->elements() as $element) {
            if ($element['slug'] === $slug || in_array($slug, $element['aliases'], true)) {
                return $element;
            }
        }

        return null;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function elements(): array
    {
        return [
            $this->element(
                slug: 'color',
                label: 'Color',
                guideStatus: 'Implemented',
                systemStatus: 'Implemented',
                purpose: 'Color controls visual roles for content hierarchy, surfaces, fields, borders, links, actions, statuses, focus, loading, and high-contrast moments.',
                summary: 'Semantic color tokens for text, icons, borders, surfaces, actions, statuses, and shadows.',
                liveExamples: ['theme-aware swatches', 'token groups', 'layering model', 'background layering page', 'interaction states', 'semantic support colors', 'contrast moments', 'common app examples'],
                tokens: [
                    ['name' => 'Text hierarchy', 'variable' => '--ui-text-strong / --ui-text-secondary / --ui-text-muted', 'api' => 'ui-card-title, ui-card-copy, text utility classes', 'example' => '<p class="ui-card-copy">Muted supporting copy</p>'],
                    ['name' => 'Surfaces', 'variable' => '--ui-surface / --ui-surface-elevated', 'api' => 'ui-card, ui-shell-card, layout wrappers', 'example' => '<article class="ui-card">...</article>'],
                    ['name' => 'Actions', 'variable' => '--ui-action-primary-bg / --ui-action-primary-bg-hover', 'api' => 'x-ui.button semantic="primary"', 'example' => '<x-ui.button semantic="primary">Save</x-ui.button>'],
                    ['name' => 'Status', 'variable' => '--ui-status-success-bg / --ui-status-danger-bg', 'api' => 'x-ui.badge, x-ui.status, ui-inline-alert', 'example' => '<x-ui.badge tone="success">Active</x-ui.badge>'],
                    ['name' => 'Focus', 'variable' => '--ui-focus-ring', 'api' => 'focus-visible utilities and component focus rules', 'example' => 'focus-visible:ring-2 focus-visible:ring-sky-400'],
                    ['name' => 'Skeleton/loading', 'variable' => '--ui-skeleton-* queued alias / current loading utilities', 'api' => 'ui-spinner, skeleton blocks', 'example' => '<span class="ui-spinner"></span>'],
                ],
                usage: [
                    'Use when: choosing a role-based color for content, surfaces, states, feedback, or interaction.',
                    'Avoid when: selecting a raw hex value or using support color as decoration.',
                    'Common app examples: buttons, links, alerts, fields, selected table rows, status tags, icon buttons, and inverse tooltips.',
                ],
                accessibility: [
                    'Text and meaningful icons must meet contrast requirements in every supported theme.',
                    'Focus states are required for interactive elements and cannot be replaced by hover color alone.',
                    'Disabled color is intentionally low-emphasis but must remain understandable in context.',
                ],
                developerNotes: [
                    'Use role-based tokens, not raw hex values.',
                    'Blue is reserved for primary actions and links.',
                    'Support colors are reserved for semantic meaning: error, warning, success, info, and destructive intent.',
                    'State tokens are not static decoration; hover, active, selected, focus, and disabled states must remain state-specific.',
                ],
                related: [
                    ['label' => 'Button component', 'href' => '/platform/ui-reference/components/button'],
                    ['label' => 'Notification component', 'href' => '/platform/ui-reference/components/notification'],
                    ['label' => 'Background Layering', 'href' => '/platform/ui-reference/elements/color/layering'],
                    ['label' => 'Canonical color doc', 'href' => '/platform/docs?path=02-standards%2Fui%2Felements%2Fcolor.md'],
                    ['label' => 'Carbon color overview', 'href' => 'https://carbondesignsystem.com/elements/color/overview/'],
                ],
                carbonComparison: 'Carbon color tokens inform the role-driven architecture. Login App keeps its own semantic CSS variables and values.',
            ),
            $this->element(
                slug: 'themes',
                label: 'Themes',
                guideStatus: 'Implemented',
                systemStatus: 'Partial',
                purpose: 'Themes change token values while preserving token roles across light, dark, inline, inverse, and high-contrast contexts.',
                summary: 'Light and dark token inheritance for surfaces, text, borders, actions, and statuses.',
                liveExamples: ['theme matrix', 'component preview matrix', 'layer inheritance', 'inline theme examples', 'approved overrides'],
                tokens: [
                    ['name' => 'Resolved theme root', 'variable' => ':root and html[data-theme-resolved="light"]', 'api' => 'theme resolver on document element', 'example' => 'html[data-theme-resolved="light"] { --ui-surface: ... }'],
                    ['name' => 'Theme surfaces', 'variable' => '--ui-surface / --ui-surface-elevated', 'api' => 'ui-card and layout surfaces', 'example' => '<section class="ui-card">...</section>'],
                    ['name' => 'Theme actions', 'variable' => '--ui-action-*', 'api' => 'x-ui.button semantic variants', 'example' => '<x-ui.button semantic="danger">Delete</x-ui.button>'],
                ],
                usage: [
                    'Use when: a whole surface or theme context must resolve through the active app theme.',
                    'Avoid when: changing one component color directly instead of using token roles.',
                    'Common app examples: light page with dark shell, dark modal panel, nested card, notification, and form controls.',
                ],
                accessibility: [
                    'Every supported theme must preserve contrast for text, icons, focus rings, and semantic feedback.',
                    'Inline high-contrast contexts must keep focus and status treatment visible.',
                ],
                developerNotes: [
                    'Themes change token values, not token roles.',
                    'Do not hard-code component colors inside theme-specific markup.',
                    'Any custom theme override must document reason, owner, and source file.',
                    'Test components against all supported theme contexts before marking them complete.',
                ],
                related: [
                    ['label' => 'Color element', 'href' => '/platform/ui-reference/elements/color'],
                    ['label' => 'UI shell', 'href' => '/platform/ui-reference/components/ui-shell'],
                    ['label' => 'Canonical themes doc', 'href' => '/platform/docs?path=02-standards%2Fui%2Felements%2Fthemes.md'],
                    ['label' => 'Carbon themes overview', 'href' => 'https://carbondesignsystem.com/elements/themes/overview/'],
                ],
                carbonComparison: 'Carbon themes inform token inheritance and layer thinking. Login App keeps its own theme names, values, and CSS variable model.',
            ),
            $this->element(
                slug: '2x-grid',
                label: '2x Grid',
                guideStatus: 'Implemented',
                systemStatus: 'Partial',
                purpose: '2x Grid controls page-level structure, responsive regions, column spans, gutters, and app shell alignment.',
                summary: 'Responsive page, section, dashboard, and widget geometry.',
                liveExamples: ['responsive grid visualizer', 'breakpoint examples', 'column spans', 'gutter examples', 'padding and margin alignment', 'fluid fixed hybrid regions', 'app scaffold'],
                tokens: [
                    ['name' => 'Mini unit', 'variable' => '8px-centered spacing model', 'api' => 'Tailwind gap/padding utilities and app grid wrappers', 'example' => 'grid gap-4 md:grid-cols-2 xl:grid-cols-4'],
                    ['name' => 'Dashboard grid', 'variable' => '--ui-dashboard-grid-row-size / --ui-dashboard-grid-gap', 'api' => 'x-ui.patterns.dashboard-grid', 'example' => '<x-ui.patterns.dashboard-grid>...</x-ui.patterns.dashboard-grid>'],
                    ['name' => 'Content region', 'variable' => 'layout-owned max width and grid columns', 'api' => 'page shell and pattern wrappers', 'example' => '<section class="grid gap-4 xl:grid-cols-4">...</section>'],
                ],
                usage: [
                    'Use when: defining page, section, dashboard, app-shell, or large content-region geometry.',
                    'Avoid when: adding arbitrary row/column wrappers for local component spacing.',
                    'Common app examples: dashboard widgets, settings shell, tables, split views, side panels, and modals.',
                ],
                accessibility: [
                    'Responsive reflow must preserve source order and focus order.',
                    'Grid overlays are visual aids only; semantic landmarks still come from markup.',
                ],
                developerNotes: [
                    'Use grid for page-level structure; use spacing tokens for local relationships inside components.',
                    'Do not assume Bootstrap or ad hoc row/column layouts satisfy the app grid standard.',
                    'Test at 320px, 672px, 1056px, 1312px, and 1584px when grid alignment matters.',
                ],
                related: [
                    ['label' => 'Spacing element', 'href' => '/platform/ui-reference/elements/spacing'],
                    ['label' => 'Layout patterns', 'href' => '/platform/ui-reference/patterns/layout'],
                    ['label' => 'Canonical 2x Grid doc', 'href' => '/platform/docs?path=02-standards%2Fui%2Felements%2F2x-grid.md'],
                    ['label' => 'Carbon 2x Grid overview', 'href' => 'https://carbondesignsystem.com/elements/2x-grid/overview/'],
                ],
                carbonComparison: 'Carbon 2x Grid maps to Login App as an 8px-compatible layout foundation, not a Carbon column system clone.',
                aliases: ['grid'],
            ),
            $this->element(
                slug: 'spacing',
                label: 'Spacing',
                guideStatus: 'Implemented',
                systemStatus: 'Partial',
                purpose: 'Spacing controls layout rhythm, component padding, content relationships, density, and visual hierarchy.',
                summary: 'Component internal spacing and parent-owned layout spacing.',
                liveExamples: ['spacing scale', 'margin examples', 'padding examples', 'stack examples', 'relationship examples', 'density examples'],
                tokens: [
                    ['name' => '$spacing-01', 'variable' => '0.125rem / 2px', 'api' => 'gap-0.5 / p-0.5 equivalent', 'example' => 'fine separator or hairline relationship'],
                    ['name' => '$spacing-03', 'variable' => '0.5rem / 8px', 'api' => 'gap-2 / p-2', 'example' => 'label to helper relationship'],
                    ['name' => '$spacing-05', 'variable' => '1rem / 16px', 'api' => 'gap-4 / p-4', 'example' => 'standard compact panel rhythm'],
                    ['name' => '$spacing-07', 'variable' => '2rem / 32px', 'api' => 'gap-8 / p-8', 'example' => 'section separation'],
                    ['name' => '$spacing-13', 'variable' => '10rem / 160px', 'api' => 'large layout spacing only', 'example' => 'rare large empty/hero-like spacing'],
                ],
                usage: [
                    'Use when: defining margin, padding, gaps, stack rhythm, component internals, or layout relationships.',
                    'Avoid when: setting arbitrary pixel values or component-owned external margins.',
                    'Common app examples: form rows, action rows, table cells, cards, dashboard widgets, and page sections.',
                ],
                accessibility: [
                    'Spacing must support readable grouping and hit areas.',
                    'Dense layouts still need enough spacing for focus indicators and validation text.',
                ],
                developerNotes: [
                    'Use spacing tokens for margin, padding, and gaps.',
                    'Components own internal spacing; parent layouts own external spacing.',
                    'Smaller spacing creates close relationships; larger spacing separates sections and creates hierarchy.',
                ],
                related: [
                    ['label' => '2x Grid element', 'href' => '/platform/ui-reference/elements/2x-grid'],
                    ['label' => 'Form patterns', 'href' => '/platform/ui-reference/patterns/forms'],
                    ['label' => 'Canonical spacing doc', 'href' => '/platform/docs?path=02-standards%2Fui%2Felements%2Fspacing.md'],
                    ['label' => 'Carbon spacing overview', 'href' => 'https://carbondesignsystem.com/elements/spacing/overview/'],
                ],
                carbonComparison: 'Carbon spacing tokens and stack guidance support the same ownership principle: components do not rely on self-owned margins.',
            ),
            $this->element(
                slug: 'typography',
                label: 'Typography',
                guideStatus: 'Implemented',
                systemStatus: 'Implemented',
                purpose: 'Typography controls readable hierarchy, Productive and Expressive Type Sets, role-based text styling, labels, helper text, validation, captions, links, and code.',
                summary: 'Type sets, type roles, hierarchy, text color, labels, helper copy, and code text.',
                liveExamples: ['type sets overview', 'font specimens', 'type scale', 'type roles', 'productive examples', 'expressive examples', 'weight examples', 'color examples', 'content examples'],
                tokens: [
                    ['name' => 'Productive context', 'variable' => '--ui-type-productive-base-size', 'api' => 'ui-type-set-productive', 'example' => '<section class="ui-type-set-productive">...</section>'],
                    ['name' => 'Expressive context', 'variable' => '--ui-type-expressive-base-size / --ui-type-fluid-max', 'api' => 'ui-type-set-expressive', 'example' => '<section class="ui-type-set-expressive">...</section>'],
                    ['name' => 'Productive headings', 'variable' => '--ui-type-productive-heading-scale', 'api' => 'ui-type-productive-heading-01...06', 'example' => '<h2 class="ui-type-productive-heading-03">Section</h2>'],
                    ['name' => 'Expressive headings', 'variable' => '--ui-type-expressive-heading-scale', 'api' => 'ui-type-expressive-heading-01...06 / display-01 / display-02', 'example' => '<h2 class="ui-type-expressive-heading-05">Help intro</h2>'],
                    ['name' => 'Page title', 'variable' => '--ui-text-strong', 'api' => 'ui-page-header-title', 'example' => '<h1 class="ui-page-header-title">Settings</h1>'],
                    ['name' => 'Card title', 'variable' => '--ui-text-strong', 'api' => 'ui-card-title', 'example' => '<h2 class="ui-card-title">Workspace</h2>'],
                    ['name' => 'Body/helper', 'variable' => '--ui-text-secondary / --ui-text-muted', 'api' => 'ui-card-copy and helper text classes', 'example' => '<p class="ui-card-copy">Supporting copy</p>'],
                    ['name' => 'Code/mono', 'variable' => '--ui-font-family-mono', 'api' => 'ui-type-code-01 / ui-type-code-02 / code snippet utilities', 'example' => '<code class="ui-type-code-02">--ui-text-strong</code>'],
                ],
                usage: [
                    'Use when: selecting text role, hierarchy, label treatment, helper text, validation, captions, links, or code.',
                    'Avoid when: guessing size, weight, line-height, or color by visual preference.',
                    'Common app examples: admin page titles, settings forms, data tables, empty states, notifications, inline validation, docs intros, and approved high-presence help moments.',
                ],
                accessibility: [
                    'Running text must remain legible in every theme.',
                    'Validation text must not rely on color alone.',
                    'Links need visible affordance and focus state.',
                    'Fluid expressive headings must remain readable and must not crowd controls or hide content at small breakpoints.',
                ],
                developerNotes: [
                    'Use typography tokens by role.',
                    'Productive type is the default for app UI; expressive type is installed but selected intentionally by Component or Pattern context.',
                    'Use neutral color for running text; use blue only for links and actions.',
                    'Use semibold for headings and emphasis, not long body copy.',
                    'Do not use external production type class names or arbitrary local size/line-height utilities as public app APIs.',
                ],
                related: [
                    ['label' => 'Typography Type Sets', 'href' => '/platform/ui-reference/elements/typography/type-sets'],
                    ['label' => 'Color element', 'href' => '/platform/ui-reference/elements/color'],
                    ['label' => 'Form patterns', 'href' => '/platform/ui-reference/patterns/forms'],
                    ['label' => 'Canonical typography doc', 'href' => '/platform/docs?path=02-standards%2Fui%2Felements%2Ftypography.md'],
                    ['label' => 'Carbon typography overview', 'href' => 'https://carbondesignsystem.com/elements/typography/overview/'],
                ],
                carbonComparison: 'Carbon typography informs the productive and expressive type-set structure. Login App keeps system fonts, app-owned classes, and app token values.',
            ),
            $this->element(
                slug: 'icons',
                label: 'Icons',
                guideStatus: 'Implemented',
                systemStatus: 'Partial',
                purpose: 'Icons communicate actions, status, navigation, and affordances at dense UI scale.',
                summary: 'Heroicons-backed UI icon usage for actions, navigation, statuses, and affordances.',
                liveExamples: ['approved Heroicons table', 'icon sizes', 'icon with text', 'icon-only controls', 'status icons', 'decorative versus meaningful', 'hit target demo'],
                tokens: [
                    ['name' => 'Dense UI icon', 'variable' => 'currentColor from text/status/action token', 'api' => 'Heroicon h-4 w-4', 'example' => '<x-heroicon-o-check-circle class="h-4 w-4" />'],
                    ['name' => 'Action icon', 'variable' => 'currentColor from button/menu item', 'api' => 'Heroicon h-5 w-5', 'example' => '<x-heroicon-o-cog-6-tooth class="h-5 w-5" />'],
                    ['name' => 'Touch target', 'variable' => '44px minimum target', 'api' => 'h-11 w-11 icon button wrapper', 'example' => '<button class="h-11 w-11" aria-label="Open filters">...</button>'],
                ],
                usage: [
                    'Use when: an icon helps identify action, status, navigation, or affordance.',
                    'Avoid when: the icon is decoration with no meaning.',
                    'Common app examples: menu items, icon buttons, statuses, inline validation, notifications, and table actions.',
                ],
                accessibility: [
                    'Decorative icons must be aria-hidden.',
                    'Meaningful icons and icon-only buttons need accessible names.',
                    'Interactive icon controls need at least a 44px target.',
                ],
                developerNotes: [
                    'Heroicons remain the default app icon library.',
                    'Use 16px icons for dense UI; use larger sizes only when the layout requires it.',
                    'Icons are monochrome and theme-aware through currentColor.',
                    'Do not import another icon set without a separate decision record.',
                ],
                related: [
                    ['label' => 'Button component', 'href' => '/platform/ui-reference/components/button'],
                    ['label' => 'Notification component', 'href' => '/platform/ui-reference/components/notification'],
                    ['label' => 'Canonical icons doc', 'href' => '/platform/docs?path=02-standards%2Fui%2Felements%2Ficons.md'],
                    ['label' => 'Carbon icons usage', 'href' => 'https://carbondesignsystem.com/elements/icons/usage/'],
                ],
                carbonComparison: 'Carbon icon guidance informs sizing, touch targets, color, and alignment. Login App uses Heroicons.',
            ),
            $this->element(
                slug: 'pictograms',
                label: 'Pictograms',
                guideStatus: 'Implemented',
                systemStatus: 'Needs audit',
                purpose: 'Pictograms are larger illustrative assets for empty, onboarding, help, or explanatory moments; they are not UI icons.',
                summary: 'Large illustrative symbols for empty states, onboarding, or expressive content.',
                liveExamples: ['queued library disposition', 'size examples', 'productive vs expressive comparison', 'container examples', 'clearance demo', 'theme background examples', 'app usage examples'],
                tokens: [
                    ['name' => 'Minimum pictogram', 'variable' => '48px minimum', 'api' => 'queued asset class', 'example' => 'empty-state pictogram at 64px'],
                    ['name' => 'Large empty state', 'variable' => '96px to 128px+', 'api' => 'queued illustrative asset', 'example' => 'no-results panel visual'],
                    ['name' => 'Asset source', 'variable' => 'not approved', 'api' => 'future ADR required', 'example' => 'Do not import unapproved pictograms.'],
                ],
                usage: [
                    'Use when: empty, onboarding, blocked, or explanatory states need a larger visual anchor.',
                    'Avoid when: a normal UI icon, logo, button icon, or product lockup is needed.',
                    'Common app examples: empty states, onboarding panels, feature cards, help panels, and no-results states.',
                ],
                accessibility: [
                    'Pictograms must remain legible against their background.',
                    'Decorative pictograms should be hidden from assistive tech; meaningful illustrations need adjacent text.',
                    'Clearance and contrast matter more than decorative complexity.',
                ],
                developerNotes: [
                    'Pictograms remain queued until a real feature requires an asset decision.',
                    'Use productive pictograms by default if an asset library is approved later.',
                    'Do not crop, distort, recolor arbitrarily, or import pictograms without a decision record.',
                ],
                related: [
                    ['label' => 'Empty state pattern', 'href' => '/platform/ui-reference/patterns/data-content'],
                    ['label' => 'Icons element', 'href' => '/platform/ui-reference/elements/icons'],
                    ['label' => 'Canonical pictograms doc', 'href' => '/platform/docs?path=02-standards%2Fui%2Felements%2Fpictograms.md'],
                    ['label' => 'Carbon pictograms usage', 'href' => 'https://carbondesignsystem.com/elements/pictograms/usage/'],
                ],
                carbonComparison: 'Carbon pictograms are a useful category reference. Login App does not currently adopt Carbon pictogram assets.',
            ),
            $this->element(
                slug: 'motion',
                label: 'Motion',
                guideStatus: 'Implemented',
                systemStatus: 'Partial',
                purpose: 'Motion clarifies state change for hover, focus, overlays, loading, feedback, and reduced-motion contexts.',
                summary: 'Transitions and reduced-motion behavior for hover, focus, overlays, loading, and feedback.',
                liveExamples: ['productive motion examples', 'expressive motion gate', 'component-owned motion proof', 'pattern-owned motion gates', 'reduced motion preview', 'do and do not samples'],
                tokens: [
                    ['name' => 'Productive transition', 'variable' => 'transition duration-150 ease-out', 'api' => 'control hover/focus classes', 'example' => 'hover:border-sky-400 transition'],
                    ['name' => 'Overlay transition', 'variable' => 'current modal/drawer transition classes', 'api' => 'ui-modal-panel / drawer surfaces', 'example' => 'modal enter/exit treatment'],
                    ['name' => 'Reduced motion', 'variable' => '@media (prefers-reduced-motion: reduce)', 'api' => 'CSS media feature', 'example' => 'disable non-essential transform motion'],
                ],
                usage: [
                    'Use when: motion guides, clarifies, or confirms state change.',
                    'Avoid when: motion is decorative friction, bounce, stretch, sudden stop, or delays usable content.',
                    'Common app examples: dropdowns, modals, toasts, accordions, side panels, table sorting, and loading skeletons.',
                ],
                accessibility: [
                    'Respect prefers-reduced-motion.',
                    'Motion must not be the only signal of meaning.',
                    'Reduced-motion users must retain equivalent state visibility and feedback.',
                ],
                developerNotes: [
                    'Productive motion is default for admin UI.',
                    'Expressive motion is gated until a product or Pattern owner approves a concrete use case.',
                    'Use entrance easing when adding UI and exit easing when removing UI.',
                    'Avoid bounce, decorative spin, excessive distance, and long animations.',
                ],
                related: [
                    ['label' => 'Overlays and feedback', 'href' => '/platform/ui-reference/patterns/overlays-feedback'],
                    ['label' => 'Loading component', 'href' => '/platform/ui-reference/components/loading'],
                    ['label' => 'Canonical motion doc', 'href' => '/platform/docs?path=02-standards%2Fui%2Felements%2Fmotion.md'],
                    ['label' => 'Carbon motion overview', 'href' => 'https://carbondesignsystem.com/elements/motion/overview/'],
                    ['label' => 'MDN prefers-reduced-motion', 'href' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/@media/prefers-reduced-motion'],
                ],
                carbonComparison: 'Carbon motion guidance informs purposeful state-change motion. Login App keeps restrained interaction motion.',
            ),
        ];
    }

    /**
     * @param array<int, string> $liveExamples
     * @param array<int, array{name: string, variable: string, api: string, example: string}> $tokens
     * @param array<int, string> $usage
     * @param array<int, string> $accessibility
     * @param array<int, string> $developerNotes
     * @param array<int, array{label: string, href: string}> $related
     * @param array<int, string> $aliases
     *
     * @return array<string, mixed>
     */
    private function element(
        string $slug,
        string $label,
        string $guideStatus,
        string $systemStatus,
        string $purpose,
        string $summary,
        array $liveExamples,
        array $tokens,
        array $usage,
        array $accessibility,
        array $developerNotes,
        array $related,
        string $carbonComparison,
        array $aliases = [],
    ): array {
        $docPath = '02-standards/ui/elements/'.$slug.'.md';

        return [
            'slug' => $slug,
            'label' => $label,
            'disposition' => $guideStatus,
            'status' => $guideStatus,
            'guide_status' => $guideStatus,
            'system_status' => $systemStatus,
            'purpose' => $purpose,
            'summary' => $summary,
            'visible_examples' => $liveExamples,
            'live_examples' => $liveExamples,
            'token_reference' => $tokens,
            'usage_guidance' => $usage,
            'accessibility_notes' => $accessibility,
            'developer_notes' => $developerNotes,
            'related_links' => $related,
            'carbon_comparison' => $carbonComparison,
            'doc_path' => $docPath,
            'doc_route' => '/platform/docs?path='.rawurlencode($docPath),
            'route_name' => 'platform.ui-reference.elements.show',
            'aliases' => $aliases,
        ];
    }
}
