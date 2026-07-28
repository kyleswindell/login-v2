# docs/02-standards/testing AGENTS.md

## Purpose

This folder owns canonical testing and verification rules.

## Read Order

1. Read `index.md`.
2. Read `testing-and-verification-standards.md` for the shared taxonomy and mandatory baseline.
3. Read only the specialist standard applicable to the current work.
4. Read Security, Database, UI, Documentation, or Runbook standards when those owners define additional domain-specific requirements.

## Authority Boundary

This folder owns:

- test and verification terminology;
- proof selection and evidence rules;
- result classification;
- automated and static test construction;
- test environments, fixtures, and data;
- integration, system, and acceptance testing;
- reliability, performance, compatibility, and operational testing;
- UI, accessibility, browser, interaction, and motion testing;
- testing gates and result reporting.

This folder does not own:

- feature behavior;
- architecture;
- exact schema contracts;
- security-control requirements;
- UI component public APIs;
- operational procedures;
- GitHub issue status;
- implementation sequencing.

## Avoid

- Do not treat a test level as a quality characteristic.
- Do not treat a browser runner as proof of visual acceptance.
- Do not duplicate OWASP ASVS requirements from Security standards.
- Do not weaken accepted tests or fixtures without explicit revision authority.
- Do not classify environment, syntax, fixture, dependency, or tooling failures as expected missing behavior.
