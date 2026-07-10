# app AGENTS.md

## Purpose

Laravel application code. This folder owns backend application behavior, service classes, controllers, models, providers, policies, and Livewire classes.

## Read Order

1. Identify the route, controller, Livewire class, service, model, or policy tied to the task.
2. Read only directly connected classes before expanding.
3. Cross-check feature, architecture, database, and standards docs only when the code change crosses those contracts.

## Avoid

- Do not scan all application classes for a narrow route or UI fix.
- Do not change tenant isolation, authorization, or provisioning behavior without checking the owning canonical docs.
- Do not encode documentation-only decisions directly in code without an implementation requirement.
