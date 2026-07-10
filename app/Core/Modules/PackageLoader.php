<?php
/*
|--------------------------------------------------------------------------
| File: app/Core/Modules/PackageLoader.php
| Purpose: Loads enabled module packages in dependency-safe order.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Core\Modules;

use InvalidArgumentException;

final class PackageLoader
{
    public function __construct(
        private readonly PackageRegistrar $registrar,
    ) {
    }

    /**
     * @param  list<array<string, mixed>>  $definitions
     */
    public function load(array $definitions): void
    {
        foreach ($this->orderedDefinitions($definitions) as $definition) {
            $this->registrar->register($definition);
        }
    }

    /**
     * @param  list<array<string, mixed>>  $definitions
     * @return list<array<string, mixed>>
     */
    private function orderedDefinitions(array $definitions): array
    {
        $core = [];
        $enabledOptional = [];

        foreach ($definitions as $definition) {
            $manifest = $this->manifest($definition);

            if ($manifest->type === Category::Core) {
                $core[$manifest->key] = $definition;
                continue;
            }

            if (
                $manifest->installedByDefault
                && $manifest->defaultEnabled
                && $manifest->defaultState === LifecycleState::Enabled
            ) {
                $enabledOptional[$manifest->key] = $definition;
            }
        }

        return [
            ...$this->sortByAvailableDependencies($core),
            ...$this->sortByAvailableDependencies($enabledOptional),
        ];
    }

    /**
     * @param  array<string, array<string, mixed>>  $definitions
     * @return list<array<string, mixed>>
     */
    private function sortByAvailableDependencies(array $definitions): array
    {
        $ordered = [];
        $visiting = [];
        $visited = [];

        foreach (array_keys($definitions) as $key) {
            $this->visit($key, $definitions, $ordered, $visiting, $visited);
        }

        return $ordered;
    }

    /**
     * @param  array<string, array<string, mixed>>  $definitions
     * @param  list<array<string, mixed>>  $ordered
     * @param  array<string, bool>  $visiting
     * @param  array<string, bool>  $visited
     */
    private function visit(
        string $key,
        array $definitions,
        array &$ordered,
        array &$visiting,
        array &$visited,
    ): void {
        if (isset($visited[$key])) {
            return;
        }

        if (isset($visiting[$key])) {
            throw new InvalidArgumentException("Module package dependency cycle detected at [{$key}].");
        }

        if (! isset($definitions[$key])) {
            return;
        }

        $visiting[$key] = true;
        $manifest = $this->manifest($definitions[$key]);

        foreach ($manifest->dependencies as $dependency) {
            if (isset($definitions[$dependency])) {
                $this->visit($dependency, $definitions, $ordered, $visiting, $visited);
            }
        }

        unset($visiting[$key]);
        $visited[$key] = true;
        $ordered[] = $definitions[$key];
    }

    /**
     * @param  array<string, mixed>  $definition
     */
    private function manifest(array $definition): Manifest
    {
        $manifest = $definition['manifest'] ?? null;

        if (! $manifest instanceof Manifest) {
            throw new InvalidArgumentException('Module package definition is missing a valid manifest.');
        }

        return $manifest;
    }
}
