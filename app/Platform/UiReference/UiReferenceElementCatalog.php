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
            if ($element['slug'] === $slug) {
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
                'grid',
                'Grid',
                'Partially Implemented',
                'Responsive page, section, dashboard, and widget geometry.',
                ['2x/8px-compatible spacing decision', 'page content regions', 'card grids', 'dashboard widget grid'],
                ['Use grid and gap wrappers for layout. Components do not own external margins.', 'The current dashboard grid is accepted; broader 2x enforcement is queued for review.'],
                'Carbon 2x Grid maps to Login App as an 8px-compatible layout foundation, not a Carbon column system clone.',
            ),
            $this->element(
                'color',
                'Color',
                'Implemented',
                'Semantic color tokens for text, icons, borders, surfaces, actions, and statuses.',
                ['light/dark text tokens', 'surface tokens', 'action tokens', 'status tokens'],
                ['Use semantic tokens instead of hard-coded component colors.', 'Primary text is content hierarchy; primary action is an action namespace.'],
                'Carbon color tokens map to Login App semantic CSS variables rather than IBM palette names.',
            ),
            $this->element(
                'icons',
                'Icons',
                'Partially Implemented',
                'Heroicons-backed UI icon usage for actions, navigation, statuses, and affordances.',
                ['16px inline icon', '20px action icon', '44px touch target', 'decorative vs semantic icon'],
                ['Heroicons remain the default icon library.', 'Icons inherit text or action color and should remain monochrome.'],
                'Carbon icon usage maps to Heroicon sizing, touch-target, and alignment rules.',
            ),
            $this->element(
                'pictograms',
                'Pictograms',
                'Queued Gap',
                'Large illustrative symbols for empty states, onboarding, or expressive content.',
                ['queued trigger condition', 'minimum size guidance', 'not a UI icon replacement'],
                ['Do not import Carbon pictograms without a separate decision record.', 'Use only when a feature needs larger illustrative support.'],
                'Carbon pictograms are treated as a future illustrative asset category, not a current dependency.',
            ),
            $this->element(
                'motion',
                'Motion',
                'Partially Implemented',
                'Transitions and reduced-motion behavior for hover, focus, overlays, loading, and feedback.',
                ['hover transition', 'focus transition', 'toast motion', 'drawer/modal motion', 'reduced motion'],
                ['Motion must clarify state change, not decorate.', 'Reduced-motion users must not lose feedback meaning.'],
                'Carbon motion guidance maps to local transition and reduced-motion rules.',
            ),
            $this->element(
                'spacing',
                'Spacing',
                'Partially Implemented',
                'Component internal spacing and parent-owned layout spacing.',
                ['spacing scale', 'stack/gap wrapper', 'form row', 'action row', 'table cell', 'card grid'],
                ['Components own internal padding and gaps.', 'Parent layouts own external spacing through gap, grid, stack, row, or cell patterns.'],
                'Carbon spacing tokens map to a Tailwind-compatible 8px-centered spacing model.',
            ),
            $this->element(
                'themes',
                'Themes',
                'Implemented',
                'Light and dark token inheritance for surfaces, text, borders, actions, and statuses.',
                ['dark theme token set', 'light theme token set', 'theme inheritance', 'accepted aliases'],
                ['Theme changes must be token-level changes.', 'Do not add theme-specific component overrides without a standard.'],
                'Carbon theme architecture maps to Login App root and resolved-theme CSS variables.',
            ),
            $this->element(
                'typography',
                'Typography',
                'Partially Implemented',
                'Type roles, hierarchy, text color, labels, helper copy, and code text.',
                ['page title', 'section title', 'card title', 'table header', 'body', 'muted text', 'label', 'helper', 'error', 'code'],
                ['Typography examples should apply the final styling directly.', 'Type color uses text tokens and never action color except links/actions.'],
                'Carbon typography maps to Login App type roles, not IBM Plex-specific type sets.',
            ),
        ];
    }

    /**
     * @param array<int, string> $examples
     * @param array<int, string> $rules
     *
     * @return array<string, mixed>
     */
    private function element(
        string $slug,
        string $label,
        string $disposition,
        string $summary,
        array $examples,
        array $rules,
        string $carbonComparison,
    ): array {
        $docPath = '02-standards/ui/elements/'.$slug.'.md';

        return [
            'slug' => $slug,
            'label' => $label,
            'disposition' => $disposition,
            'summary' => $summary,
            'visible_examples' => $examples,
            'rules' => $rules,
            'carbon_comparison' => $carbonComparison,
            'doc_path' => $docPath,
            'doc_route' => '/platform/docs?path='.rawurlencode($docPath),
            'route_name' => 'platform.ui-reference.elements.show',
        ];
    }
}
