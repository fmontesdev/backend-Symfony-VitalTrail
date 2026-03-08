---
name: symfony-feature-module-scaffold
description: Scaffold new feature modules with Domain/Application/Infrastructure/Presentation structure and CQRS handlers. Use when creating a new bounded feature in Symfony.
---

## Goal
Create consistent feature skeletons that fit clean + hexagonal + CQRS architecture.

## Suggested feature layout
- `Domain/` (entities, value objects, domain services, domain exceptions)
- `Application/Command/` (commands + handlers)
- `Application/Query/` (queries + handlers)
- `Application/Port/` (repository/service interfaces)
- `Infrastructure/Persistence/Doctrine/` (entities/mappers/repos adapters)
- `Infrastructure/ApiPlatform/` (providers/processors, if used)
- `Presentation/Http/` (controllers or API resource wiring)

## Rules
- Name commands/queries by use case, not CRUD verb alone.
- Keep mappers explicit between layers.
- Keep shared kernel minimal; avoid premature abstractions.

## Done checklist
- One command handler and one query handler path compile.
- Ports have at least one adapter.
- API entrypoint delegates and stays thin.
- Tests cover minimum happy path for command + query.
