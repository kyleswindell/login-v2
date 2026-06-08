<?php

namespace App\Platform\UiReference;

class UiReferenceColorTokenPalette
{
    /**
     * @return array<int, array{family: string, carbon_family: string, disposition: string, owner: string, notes: string}>
     */
    public function inventory(): array
    {
        return [
            ['family' => 'Background', 'carbon_family' => 'Background', 'disposition' => 'Implemented', 'owner' => '/platform/ui-reference/elements/color/tokens#background-layer-field', 'notes' => 'App-owned background tokens map the global canvas, hover, active, selected, inverse, and brand roles.'],
            ['family' => 'Layer', 'carbon_family' => 'Layer', 'disposition' => 'Implemented', 'owner' => '/platform/ui-reference/elements/color/tokens#background-layer-field', 'notes' => 'Layer depth is represented as first, second, and third nested surfaces for light and dark contexts.'],
            ['family' => 'Layer accent', 'carbon_family' => 'Layer accent', 'disposition' => 'Implemented', 'owner' => '/platform/ui-reference/elements/color/tokens#background-layer-field', 'notes' => 'Accent layers are neutral depth helpers for secondary surface contrast, not semantic status color.'],
            ['family' => 'Field', 'carbon_family' => 'Field', 'disposition' => 'Implemented', 'owner' => '/platform/ui-reference/elements/color/tokens#background-layer-field', 'notes' => 'Field tokens support input surfaces on background and nested layer contexts.'],
            ['family' => 'Border', 'carbon_family' => 'Border', 'disposition' => 'Implemented', 'owner' => '/platform/ui-reference/elements/color/tokens#border', 'notes' => 'Subtle, strong, interactive, inverse, and disabled border roles are available as app tokens.'],
            ['family' => 'Text', 'carbon_family' => 'Text', 'disposition' => 'Implemented', 'owner' => '/platform/ui-reference/elements/color/tokens#text-icon', 'notes' => 'Text roles include primary, secondary, placeholder, helper, error, inverse, and disabled.'],
            ['family' => 'Link', 'carbon_family' => 'Link', 'disposition' => 'Implemented', 'owner' => '/platform/ui-reference/elements/color/tokens#link', 'notes' => 'Primary, hover, inverse, and visited link roles are represented.'],
            ['family' => 'Syntax', 'carbon_family' => 'Syntax', 'disposition' => 'Implemented', 'owner' => '/platform/ui-reference/elements/color/tokens#syntax-code', 'notes' => 'Syntax tokens cover common code roles used in docs and implementation examples.'],
            ['family' => 'Icon', 'carbon_family' => 'Icon', 'disposition' => 'Implemented', 'owner' => '/platform/ui-reference/elements/color/tokens#text-icon', 'notes' => 'Icon roles are explicit aliases instead of relying only on text tokens.'],
            ['family' => 'Support / status', 'carbon_family' => 'Support', 'disposition' => 'Implemented', 'owner' => '/platform/ui-reference/elements/color/tokens#support-status', 'notes' => 'Support roles map semantic status, alert, and feedback color.'],
            ['family' => 'Focus', 'carbon_family' => 'Focus', 'disposition' => 'Implemented', 'owner' => '/platform/ui-reference/elements/color/tokens#focus-skeleton', 'notes' => 'Focus, focus inset, and inverse focus roles are represented.'],
            ['family' => 'Miscellaneous / inverse / skeleton', 'carbon_family' => 'Miscellaneous', 'disposition' => 'Queued Token Gap', 'owner' => '/platform/ui-reference/elements/color/tokens#focus-skeleton', 'notes' => 'Inverse and skeleton roles are represented; broader miscellaneous token coverage remains queued until a concrete component requires it.'],
            ['family' => 'Component tokens', 'carbon_family' => 'Component Tokens', 'disposition' => 'Covered By App Alias', 'owner' => '/platform/ui-reference/elements/color/tokens#component-ai-disposition', 'notes' => 'Login App currently exposes component behavior through T1 classes plus app role tokens instead of a separate component-token package.'],
            ['family' => 'AI tokens', 'carbon_family' => 'AI Tokens', 'disposition' => 'Not Applicable Yet', 'owner' => '/platform/ui-reference/elements/color/tokens#component-ai-disposition', 'notes' => 'AI-specific color roles remain gated until an AI feature or decision record requires them.'],
        ];
    }

    /**
     * @return array<int, array{slug: string, label: string, summary: string, rows: array<int, array<string, string>>}>
     */
    public function families(): array
    {
        return [
            [
                'slug' => 'background-layer-field',
                'label' => 'Background / Layer / Field',
                'summary' => 'Global canvas, nested surfaces, layer accents, and field surfaces.',
                'rows' => [
                    $this->row('Background', 'Page background', '--ui-background', 'rgb(248 250 252)', 'rgb(9 9 11)', 'Implemented', 'Global background role, app-owned value.'),
                    $this->row('Background', 'Background hover', '--ui-background-hover', 'rgb(241 245 249)', 'rgb(39 39 42)', 'Implemented', 'Background hover behavior, app ramp.'),
                    $this->row('Background', 'Background active', '--ui-background-active', 'rgb(226 232 240)', 'rgb(63 63 70)', 'Implemented', 'Active state darkens/lightens by context.'),
                    $this->row('Background', 'Selected background', '--ui-background-selected', 'rgb(224 242 254)', 'rgb(29 78 216 / 0.24)', 'Implemented', 'Selected state uses persistent emphasis, not press color.'),
                    $this->row('Background', 'Inverse background', '--ui-background-inverse', 'rgb(15 23 42)', 'rgb(244 244 245)', 'Implemented', 'High-contrast moments use inverse surface reasoning.'),
                    $this->row('Layer', 'Layer 01', '--ui-layer-01', 'rgb(255 255 255)', 'rgb(24 24 27 / 0.9)', 'Implemented', 'First container on background.'),
                    $this->row('Layer', 'Layer 02', '--ui-layer-02', 'rgb(248 250 252)', 'rgb(39 39 42)', 'Implemented', 'Nested container on layer 01.'),
                    $this->row('Layer', 'Layer 03', '--ui-layer-03', 'rgb(255 255 255)', 'rgb(63 63 70)', 'Implemented', 'Nested container on layer 02.'),
                    $this->row('Layer accent', 'Layer accent 01', '--ui-layer-accent-01', 'rgb(241 245 249)', 'rgb(39 39 42)', 'Implemented', 'Neutral tertiary layer paired with layer 01.'),
                    $this->row('Layer accent', 'Layer accent 02', '--ui-layer-accent-02', 'rgb(226 232 240)', 'rgb(63 63 70)', 'Implemented', 'Neutral tertiary layer paired with layer 02.'),
                    $this->row('Field', 'Field 01', '--ui-field-01', 'rgb(255 255 255)', 'rgb(24 24 27 / 0.9)', 'Implemented', 'Default field on background.'),
                    $this->row('Field', 'Field 02', '--ui-field-02', 'rgb(248 250 252)', 'rgb(39 39 42)', 'Implemented', 'Field on layer 01.'),
                    $this->row('Field', 'Field hover 01', '--ui-field-hover-01', 'rgb(241 245 249)', 'rgb(39 39 42 / 0.95)', 'Implemented', 'Field hover role, app ramp.'),
                ],
            ],
            [
                'slug' => 'border',
                'label' => 'Border',
                'summary' => 'Subtle, strong, interactive, inverse, and disabled border roles.',
                'rows' => [
                    $this->row('Border', 'Interactive border', '--ui-border-interactive', 'rgb(2 132 199)', 'rgb(96 165 250)', 'Implemented', 'Selection, active border, and actionable boundary.'),
                    $this->row('Border', 'Subtle border 00', '--ui-border-subtle-00', 'rgb(226 232 240)', 'rgb(39 39 42)', 'Implemented', 'Subtle border paired with background.'),
                    $this->row('Border', 'Subtle border 01', '--ui-border-subtle-01', 'rgb(203 213 225)', 'rgb(63 63 70)', 'Implemented', 'Subtle border paired with layer 01.'),
                    $this->row('Border', 'Strong border 01', '--ui-border-strong-01', 'rgb(100 116 139)', 'rgb(161 161 170)', 'Implemented', 'Medium contrast border for controls and dividers.'),
                    $this->row('Border', 'Inverse border', '--ui-border-inverse', 'rgb(15 23 42)', 'rgb(244 244 245)', 'Implemented', 'High contrast border on inverse surfaces.'),
                    $this->row('Border', 'Disabled border', '--ui-border-disabled', 'rgb(148 163 184)', 'rgb(113 113 122 / 0.9)', 'Implemented', 'Disabled UI boundary.'),
                ],
            ],
            [
                'slug' => 'text-icon',
                'label' => 'Text / Icon',
                'summary' => 'Content hierarchy, helper/error text, inverse text, and icon color roles.',
                'rows' => [
                    $this->row('Text', 'Primary text', '--ui-text-primary', 'rgb(15 23 42)', 'rgb(244 244 245)', 'Implemented', 'Primary body, headings, and dominant labels.'),
                    $this->row('Text', 'Secondary text', '--ui-text-secondary', 'rgb(51 65 85)', 'rgb(212 212 216)', 'Implemented', 'Secondary body and labels.'),
                    $this->row('Text', 'Placeholder text', '--ui-text-placeholder', 'rgb(100 116 139)', 'rgb(161 161 170)', 'Implemented', 'Placeholder and low-emphasis input text.'),
                    $this->row('Text', 'Helper text', '--ui-text-helper', 'rgb(100 116 139)', 'rgb(161 161 170)', 'Implemented', 'Helper and tertiary copy.'),
                    $this->row('Text', 'Error text', '--ui-text-error', 'rgb(127 29 29)', 'rgb(254 226 226)', 'Implemented', 'Validation errors and semantic danger copy.'),
                    $this->row('Text', 'Inverse text', '--ui-text-inverse', 'rgb(248 250 252)', 'rgb(15 23 42)', 'Implemented', 'Text on inverse/high-contrast surface.'),
                    $this->row('Icon', 'Primary icon', '--ui-icon-primary', 'rgb(15 23 42)', 'rgb(244 244 245)', 'Implemented', 'Meaningful primary icons.'),
                    $this->row('Icon', 'Secondary icon', '--ui-icon-secondary', 'rgb(51 65 85)', 'rgb(212 212 216)', 'Implemented', 'Paired or secondary icons.'),
                    $this->row('Icon', 'Inverse icon', '--ui-icon-inverse', 'rgb(248 250 252)', 'rgb(15 23 42)', 'Implemented', 'Icons on inverse/high-contrast surface.'),
                ],
            ],
            [
                'slug' => 'link',
                'label' => 'Link',
                'summary' => 'Primary, hover, inverse, active, and visited link roles.',
                'rows' => [
                    $this->row('Link', 'Primary link', '--ui-link-primary', 'rgb(3 105 161)', 'rgb(191 219 254)', 'Implemented', 'Primary app links.'),
                    $this->row('Link', 'Primary link hover', '--ui-link-primary-hover', 'rgb(7 89 133)', 'rgb(224 242 254)', 'Implemented', 'Hover color for app links.'),
                    $this->row('Link', 'Inverse link', '--ui-link-inverse', 'rgb(186 230 253)', 'rgb(7 89 133)', 'Implemented', 'Links on inverse surfaces.'),
                    $this->row('Link', 'Visited link', '--ui-link-visited', 'rgb(109 40 217)', 'rgb(196 181 253)', 'Implemented', 'Visited link affordance when needed.'),
                ],
            ],
            [
                'slug' => 'support-status',
                'label' => 'Support / Status',
                'summary' => 'Semantic support roles used by alerts, statuses, and inline feedback.',
                'rows' => [
                    $this->row('Support', 'Error support', '--ui-support-error', 'rgb(220 38 38)', 'rgb(248 113 113)', 'Implemented', 'Error and destructive semantic role.'),
                    $this->row('Support', 'Warning support', '--ui-support-warning', 'rgb(180 83 9)', 'rgb(250 204 21)', 'Implemented', 'Warning semantic role.'),
                    $this->row('Support', 'Success support', '--ui-support-success', 'rgb(4 120 87)', 'rgb(52 211 153)', 'Implemented', 'Success semantic role.'),
                    $this->row('Support', 'Info support', '--ui-support-info', 'rgb(14 165 233)', 'rgb(186 230 253)', 'Implemented', 'Information semantic role.'),
                    $this->row('Support', 'Notice support', '--ui-support-notice', 'rgb(109 40 217)', 'rgb(167 139 250)', 'Implemented', 'Non-warning attention role.'),
                ],
            ],
            [
                'slug' => 'focus-skeleton',
                'label' => 'Focus / Skeleton / Inverse',
                'summary' => 'Focus visibility, loading placeholder, and inverse/high-contrast roles.',
                'rows' => [
                    $this->row('Focus', 'Focus ring', '--ui-focus', 'rgb(2 132 199)', 'rgb(96 165 250)', 'Implemented', 'Primary keyboard focus ring.'),
                    $this->row('Focus', 'Focus inset', '--ui-focus-inset', 'rgb(255 255 255)', 'rgb(9 9 11)', 'Implemented', 'Inset separation when focus contrast needs help.'),
                    $this->row('Focus', 'Focus inverse', '--ui-focus-inverse', 'rgb(248 250 252)', 'rgb(15 23 42)', 'Implemented', 'Focus on inverse/high-contrast surfaces.'),
                    $this->row('Skeleton', 'Skeleton background', '--ui-skeleton-background', 'rgb(226 232 240)', 'rgb(39 39 42)', 'Implemented', 'Loading placeholder container.'),
                    $this->row('Skeleton', 'Skeleton element', '--ui-skeleton-element', 'rgb(203 213 225)', 'rgb(82 82 91)', 'Implemented', 'Loading placeholder moving element.'),
                ],
            ],
            [
                'slug' => 'syntax-code',
                'label' => 'Syntax / Code',
                'summary' => 'Code token roles for documentation, snippets, and developer-facing examples.',
                'rows' => [
                    $this->row('Syntax', 'Comment', '--ui-syntax-comment', 'rgb(4 120 87)', 'rgb(52 211 153)', 'Implemented', 'Comment text in code examples.'),
                    $this->row('Syntax', 'Keyword', '--ui-syntax-keyword', 'rgb(3 105 161)', 'rgb(147 197 253)', 'Implemented', 'Language keywords.'),
                    $this->row('Syntax', 'String', '--ui-syntax-string', 'rgb(109 40 217)', 'rgb(196 181 253)', 'Implemented', 'String literal.'),
                    $this->row('Syntax', 'Number', '--ui-syntax-number', 'rgb(4 120 87)', 'rgb(167 243 208)', 'Implemented', 'Numeric literal.'),
                    $this->row('Syntax', 'Property', '--ui-syntax-property', 'rgb(14 116 144)', 'rgb(103 232 249)', 'Implemented', 'Property or attribute name.'),
                    $this->row('Syntax', 'Punctuation', '--ui-syntax-punctuation', 'rgb(100 116 139)', 'rgb(161 161 170)', 'Implemented', 'Operators, punctuation, delimiters.'),
                ],
            ],
        ];
    }

    /**
     * @return array<int, array{label: string, href: string}>
     */
    public function relatedLinks(): array
    {
        return [
            ['label' => 'Color Overview', 'href' => '/platform/ui-reference/elements/color'],
            ['label' => 'Canonical color doc', 'href' => '/platform/docs?path=02-standards%2Fui%2Felements%2Fcolor.md'],
            ['label' => 'Color token standard', 'href' => '/platform/docs?path=02-standards%2Fui%2Ftokens%2FUI%20UX%20Color%20Token%20Standards.md'],
            ['label' => 'Carbon color tokens', 'href' => 'https://carbondesignsystem.com/elements/color/tokens/'],
        ];
    }

    /**
     * @return array<string, string>
     */
    private function row(string $family, string $role, string $variable, string $light, string $dark, string $disposition, string $comparison): array
    {
        return [
            'family' => $family,
            'role' => $role,
            'variable' => $variable,
            'light' => $light,
            'dark' => $dark,
            'disposition' => $disposition,
            'comparison' => $comparison,
        ];
    }
}
