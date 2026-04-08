# Filament And Livewire

## Role In App 2.0

Filament is the planned admin panel framework. Livewire is the reactive layer underneath many Filament interactions.

## Planned Usage

* Filament will power platform and tenant admin panels
* separate panels are expected for platform and tenant contexts
* Blade remains appropriate for bootstrap pages until panel work begins

## Best Practices For This Repo

* introduce Filament only after the core tenancy model is in place
* keep panel boundaries explicit: platform panel and tenant panel should not share implicit assumptions
* let Filament own CRUD-heavy admin experiences
* keep complex business rules in Laravel services, not buried in panel resources
* use Livewire for reactive admin behavior, not as a replacement for clear backend boundaries

## Version Direction

Official Filament docs currently point to 5.x as the stable direction. When we install Filament, prefer the current stable version unless a dependency or compatibility constraint is documented in an ADR.

## Official References

* Filament docs index: https://filamentphp.com/docs
* Filament installation: https://filamentphp.com/docs/5.x/introduction/installation/
* Filament panel configuration: https://filamentphp.com/docs/5.x/panel-configuration
* Livewire installation: https://livewire.laravel.com/docs/installation
* Livewire docs index: https://livewire.laravel.com/docs

## Practical Notes

Before installing Filament:

* finish the central tenant registry schema
* define platform vs tenant panel boundaries
* document the auth model for each panel

After installation:

* register panel providers cleanly
* verify panel paths do not conflict with app routes
* keep panel-specific boot logic explicit

## Related

* [[V2 App/Reference/Reference Index]] | [Reference Index](Reference%20Index.md)
* [[V2 App/Architecture/Stack Overview]] | [Stack Overview](../Architecture/Stack%20Overview.md)
