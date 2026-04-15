# Codex Review Checklist

## Purpose

Use this checklist when reviewing or preparing changes.

## Checklist

- Are tenant-aware reads/writes scoped correctly?
- Are admin write actions permission-checked server-side?
- Is user input validated server-side?
- Are output values escaped in views?
- Are migrations/install changes idempotent?
- Are operational failures logged without secrets?
- Are audit-worthy user/admin actions logged?
- Are vendor/framework files avoided unless explicitly required?
- Are docs updated when behavior or architecture changes?

## Related

- [[Codex/Codex Working Rules]] | [Codex Working Rules](Codex%20Working%20Rules.md)
- [[Standards/Security Standards]] | [Security Standards](../Standards/Security%20Standards.md)

