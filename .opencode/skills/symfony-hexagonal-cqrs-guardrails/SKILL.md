---
name: symfony-hexagonal-cqrs-guardrails
description: Enforce project Clean Architecture + Hexagonal + CQRS boundaries in Symfony modules. Use when implementing or refactoring use cases, handlers, providers, processors, controllers, and adapters.
---

## Goal
Keep each feature aligned with Domain/Application/Infrastructure/Presentation boundaries.

## Mandatory boundaries
- Keep business rules in Domain.
- Keep orchestration in Application.
- Keep framework and persistence details in Infrastructure.
- Keep HTTP/API entrypoints thin in Presentation.
- Do not inject Doctrine/HTTP concerns into Domain.

## CQRS flow
### Write side
- Map request DTO -> Command.
- Dispatch/execute in command handler.
- Persist through port/repository adapter.
- Return output DTO/resource, not entities.

### Read side
- Map request filters -> Query.
- Resolve in query handler or API Platform state provider.
- Read from dedicated projection/read model when needed.

## Controller/Processor rule
- Validate/authenticate/delegate only.
- No business decisions in controller/processor.

## Done checklist
- Boundaries respected.
- Command/Query names explicit and use-case based.
- Ports are interfaces; adapters stay in Infrastructure.
- Tests cover handler behavior and API contract path.
