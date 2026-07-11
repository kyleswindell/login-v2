# M0 Persistent Data Inventory Fixtures

This directory owns deterministic, repository-local fixtures for issue #31 tooling.

The completed implementation must add fixture inputs and expected outputs covering at least:

1. `multiple-migrations-one-table`
2. `create-alter-drop-chain`
3. `dynamic-table-identifiers`
4. `compound-indexes-and-unique-constraints`
5. `foreign-keys-and-delete-behavior`
6. `material-pivot-table`
7. `duplicate-migration-names`
8. `present-unregistered-migration-root`
9. `unsupported-migration-operation`
10. `planned-implemented-overlap`
11. `reviewed-field-preservation`
12. `runtime-discovery-failure-preservation`
13. `same-basename-different-paths`
14. `windows-and-posix-path-normalization`

Fixture rules:

- do not require a database
- do not execute migrations
- do not require Laravel to boot
- use synthetic, non-secret values
- keep expected output deterministic
- test collection and rendering as separate phases
- verify reviewed fields survive recollection
- verify failed runtime evidence survives static rerender
- verify source line locations and hashes where applicable
- verify unsupported syntax remains visible rather than disappearing

The checker may run these fixtures directly or invoke a dedicated fixture mode in the generator, but the normal production inventory artifacts must never be overwritten by fixture execution.
