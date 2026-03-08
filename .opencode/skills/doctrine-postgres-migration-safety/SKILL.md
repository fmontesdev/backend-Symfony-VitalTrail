---
name: doctrine-postgres-migration-safety
description: Apply a safe Doctrine migration workflow for Symfony 7.2 + PostgreSQL 17.5. Use when changing entities, indexes, constraints, or doing data backfills.
---

## Mandatory workflow
1. Update mapping/entities first.
2. Generate migration with `php bin/console make:migration`.
3. Review generated SQL before executing.
4. Run migrations with `php bin/console doctrine:migrations:migrate`.
5. Verify rollback path (or explicit irreversibility note).

## Guardrails
- Never use `doctrine:schema:update --force`.
- Prefer additive, reversible steps.
- Split risky schema + data backfill into phased migrations.
- Add indexes/constraints intentionally; avoid silent perf regressions.

## Data migration discipline
- Keep batches idempotent when possible.
- Protect large updates with chunking strategy when needed.
- Validate row counts and post-migration invariants.

## Done checklist
- Migration diff reviewed and understood.
- Up path tested locally.
- Down/rollback strategy documented.
- No manual drift between Doctrine mapping and DB schema.
