<?php

namespace App\Platform\Navigation;

use App\Models\User;
use Illuminate\Contracts\Auth\Access\Gate;

class PlatformNavigation
{
    public function __construct(private readonly Gate $gate) {}

    /**
     * @return array{
     *   primaryBase: array<int, array<string, mixed>>,
     *   primaryAdmin: array<int, array<string, mixed>>,
     *   logs: array<int, array<string, mixed>>,
     *   setupBase: array<int, array<string, mixed>>,
     *   setupAdmin: array<int, array<string, mixed>>,
     *   account: array<int, array<string, mixed>>
     * }
     */
    public function forUser(?User $user): array
    {
        $navigation = config('navigation', []);

        return [
            'primaryBase' => $this->filterAllowed($user, $navigation['primaryBase'] ?? []),
            'primaryAdmin' => $this->filterAllowed($user, $navigation['primaryAdmin'] ?? []),
            'logs' => $this->filterAllowed($user, $navigation['logs'] ?? []),
            'setupBase' => $this->filterAllowed($user, $navigation['setupBase'] ?? []),
            'setupAdmin' => $this->filterAllowed($user, $navigation['setupAdmin'] ?? []),
            'account' => $this->filterAllowed($user, $navigation['account'] ?? []),
        ];
    }

    /**
     * @param  array<int, array<string, mixed>>  $items
     * @return array<int, array<string, mixed>>
     */
    private function filterAllowed(?User $user, array $items): array
    {
        if (! $user) {
            return [];
        }

        return array_values(array_filter(
            $items,
            function (array $item) use ($user): bool {
                if (isset($item['role']) && ! $user->hasRole($item['role'])) {
                    return false;
                }

                return ! isset($item['ability']) || $this->gate->forUser($user)->allows($item['ability']);
            }
        ));
    }
}
