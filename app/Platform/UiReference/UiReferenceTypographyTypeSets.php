<?php

declare(strict_types=1);

namespace App\Platform\UiReference;

class UiReferenceTypographyTypeSets
{
    /**
     * @return array<int, array<string, string>>
     */
    public function productiveRows(): array
    {
        return [
            $this->row('Label', 'ui-type-productive-label', '12px', '400', 'Fixed', 'Dense labels, compact metadata, table-adjacent labels.', 'Do not use for section headings.'),
            $this->row('Helper', 'ui-type-productive-helper', '12px', '400', 'Fixed', 'Helper text, inline hints, secondary field context.', 'Do not use as the only validation signal.'),
            $this->row('Legal', 'ui-type-productive-legal', '12px', '400', 'Fixed', 'Legal or compliance copy that must remain readable but secondary.', 'Do not use for primary instructions.'),
            $this->row('Body compact', 'ui-type-productive-body-compact', '14px', '400', 'Fixed', 'Dense admin UI body copy and table-adjacent text.', 'Do not use for long-form help content.'),
            $this->row('Body', 'ui-type-productive-body', '14px', '400', 'Fixed', 'Default product UI copy, field descriptions, and card body text.', 'Do not use for hero or editorial moments.'),
            $this->row('Heading compact', 'ui-type-productive-heading-compact', '14px', '600', 'Fixed', 'Compact row headers, dense panel headings, and small grouped labels.', 'Do not use as a page title.'),
            $this->row('Heading 01', 'ui-type-productive-heading-01', '14px', '600', 'Fixed', 'Small component headings and repeated item titles.', 'Do not use for page hierarchy.'),
            $this->row('Heading 02', 'ui-type-productive-heading-02', '16px', '600', 'Fixed', 'Card and section headings inside product UI.', 'Do not use for expressive page intros.'),
            $this->row('Heading 03', 'ui-type-productive-heading-03', '20px', '600', 'Fixed', 'Product page section titles and local view headings.', 'Do not use for dense table cells.'),
            $this->row('Heading 04', 'ui-type-productive-heading-04', '28px', '600', 'Fixed', 'Major product surface headings where hierarchy needs emphasis.', 'Do not use inside compact controls.'),
            $this->row('Heading 05', 'ui-type-productive-heading-05', '32px', '600', 'Fixed', 'Primary admin page titles and high-level product headers.', 'Do not use repeatedly in one product surface.'),
            $this->row('Heading 06', 'ui-type-productive-heading-06', '42px', '400', 'Fixed', 'Rare large product headings where a page title needs extra presence.', 'Do not use for marketing-style display type.'),
        ];
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function expressiveRows(): array
    {
        return [
            $this->row('Label', 'ui-type-expressive-label', '14px', '400', 'Fixed', 'Support labels inside expressive help, empty state, or docs moments.', 'Do not use for form labels or dense product controls.'),
            $this->row('Helper', 'ui-type-expressive-helper', '14px', '400', 'Fixed', 'Supporting copy for expressive panels and help intros.', 'Do not use for field helper text.'),
            $this->row('Legal', 'ui-type-expressive-legal', '14px', '400', 'Fixed', 'Secondary disclaimers in expressive content moments.', 'Do not use for compact compliance text in forms.'),
            $this->row('Body compact', 'ui-type-expressive-body-compact', '16px', '400', 'Fixed', 'Short expressive supporting paragraphs.', 'Do not use in dense tables.'),
            $this->row('Body', 'ui-type-expressive-body', '16px', '400', 'Fixed', 'Readable narrative copy for docs, help, onboarding, and empty states.', 'Do not use for standard admin field rows.'),
            $this->row('Heading compact', 'ui-type-expressive-heading-compact', '16px', '600', 'Fixed', 'Compact expressive headings inside larger contextual panels.', 'Do not use as a table header.'),
            $this->row('Heading 01', 'ui-type-expressive-heading-01', '16px', '600', 'Fixed', 'Small expressive headings paired with 16px body copy.', 'Do not use for product form labels.'),
            $this->row('Heading 02', 'ui-type-expressive-heading-02', '18px', '600', 'Fixed', 'Minor expressive section headings.', 'Do not use as a default component title.'),
            $this->row('Heading 03', 'ui-type-expressive-heading-03', '20px', '600', 'Fixed', 'Expressive subsection headings in help or docs flows.', 'Do not use in dense admin tables.'),
            $this->row('Heading 04', 'ui-type-expressive-heading-04', '28px', '600', 'Fixed', 'High-presence headings for empty states and onboarding panels.', 'Do not use for repeated card titles.'),
            $this->row('Heading 05', 'ui-type-expressive-heading-05', '32px to 54px', '500', 'Fluid', 'Hero-like help intros, empty state headlines, and docs landing moments.', 'Do not use inside standard app forms.'),
            $this->row('Heading 06', 'ui-type-expressive-heading-06', '42px to 92px', '400', 'Fluid', 'Rare high-presence page moments with enough viewport space.', 'Do not use for product operation screens.'),
            $this->row('Display 01', 'ui-type-expressive-display-01', '54px to 92px', '400', 'Fluid', 'Display moments approved by a Pattern owner.', 'Do not use as an admin page title.'),
            $this->row('Display 02', 'ui-type-expressive-display-02', '60px to 92px', '300', 'Fluid', 'Largest approved display treatment for rare editorial or onboarding surfaces.', 'Do not use without Pattern review.'),
        ];
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function apiRows(): array
    {
        return [
            ['role' => 'Productive context', 'class' => 'ui-type-set-productive', 'base' => '14px', 'weight' => 'Role-owned', 'line_height' => 'Fixed product rhythm', 'owner' => 'Typography Element', 'allowed' => 'Admin/product UI by default', 'avoid' => 'Editorial display moments'],
            ['role' => 'Expressive context', 'class' => 'ui-type-set-expressive', 'base' => '16px', 'weight' => 'Role-owned', 'line_height' => 'Fixed and fluid heading rhythm', 'owner' => 'Typography Element, selected by Pattern', 'allowed' => 'Help, onboarding, empty states, docs intros', 'avoid' => 'Forms, tables, dense controls'],
            ['role' => 'Fluid bounds', 'class' => '--ui-type-fluid-min / --ui-type-fluid-max', 'base' => '32px to 92px', 'weight' => 'Role-owned', 'line_height' => 'Fluid heading/display rhythm', 'owner' => 'Typography Element', 'allowed' => 'Expressive heading and display roles', 'avoid' => 'Local arbitrary clamp values'],
            ['role' => 'Productive headings', 'class' => 'ui-type-productive-heading-01...06', 'base' => '14px to 42px', 'weight' => '600 to 400', 'line_height' => 'Fixed', 'owner' => 'Typography Element', 'allowed' => 'Product hierarchy', 'avoid' => 'Marketing/display pages'],
            ['role' => 'Expressive headings', 'class' => 'ui-type-expressive-heading-01...06', 'base' => '16px to 92px', 'weight' => '600 to 400', 'line_height' => 'Fixed then fluid', 'owner' => 'Typography Element, selected by Pattern', 'allowed' => 'High-presence content moments', 'avoid' => 'Repeated operational headings'],
            ['role' => 'Expressive display', 'class' => 'ui-type-expressive-display-01/02', 'base' => '54px to 92px', 'weight' => '400 to 300', 'line_height' => 'Fluid display', 'owner' => 'Pattern-approved usage only', 'allowed' => 'Rare display moments', 'avoid' => 'Component-local styling'],
            ['role' => 'Code text', 'class' => 'ui-type-code-01/02', 'base' => '12px or 14px', 'weight' => '400', 'line_height' => 'Fixed mono rhythm', 'owner' => 'Typography Element / Code snippet Component', 'allowed' => 'Inline code, snippets, token examples', 'avoid' => 'Running product text'],
        ];
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function blendingExamples(): array
    {
        return [
            ['name' => 'Expressive heading with productive body/actions', 'heading_class' => 'ui-type-expressive-heading-05', 'body_class' => 'ui-type-productive-body', 'summary' => 'Use an expressive headline for a high-presence empty or intro surface while keeping controls productive.'],
            ['name' => 'Expressive empty state with productive controls', 'heading_class' => 'ui-type-expressive-heading-04', 'body_class' => 'ui-type-expressive-body', 'summary' => 'Use expressive body only for the explanatory moment; action buttons still use Component typography.'],
            ['name' => 'Expressive docs/help intro with code snippet', 'heading_class' => 'ui-type-expressive-heading-03', 'body_class' => 'ui-type-productive-body', 'summary' => 'Use expressive framing for docs/help, then return implementation examples to productive code roles.'],
        ];
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function prohibitedUsage(): array
    {
        return [
            ['label' => 'Expressive form labels', 'reason' => 'Forms require productive labels so density, alignment, and validation remain stable.'],
            ['label' => 'Expressive table cell text', 'reason' => 'Tables require productive compact text for scanning and comparison.'],
            ['label' => 'Local arbitrary type utilities', 'reason' => 'Feature code must consume approved type roles instead of inventing size and line-height pairs.'],
            ['label' => 'External production type class names', 'reason' => 'Login App exposes app-owned `ui-type-*` classes only.'],
        ];
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function gatedCapabilities(): array
    {
        return [
            ['label' => 'IBM Plex adoption', 'gate' => 'Requires separate brand/typeface decision and asset loading plan.'],
            ['label' => 'Additional display roles', 'gate' => 'Requires Typography standard update, source API, and UI Reference proof.'],
            ['label' => 'Custom fluid type', 'gate' => 'Requires Pattern-level need and accessibility review.'],
            ['label' => 'Markdown/prose renderer scale', 'gate' => 'Requires docs/content Pattern ownership before public API exposure.'],
        ];
    }

    /**
     * @return array<string, string>
     */
    private function row(string $role, string $class, string $size, string $weight, string $behavior, string $allowed, string $avoid): array
    {
        return [
            'role' => $role,
            'class' => $class,
            'size' => $size,
            'weight' => $weight,
            'behavior' => $behavior,
            'allowed' => $allowed,
            'avoid' => $avoid,
        ];
    }
}
