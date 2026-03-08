---
name: api-platform-cqrs-operation-map
description: Map API Platform operations to CQRS providers/processors and DTO contracts. Use when adding or changing resources, operations, serialization, security, and OpenAPI docs.
---

## Goal
Keep API Platform as an explicit contract layer over CQRS use cases.

## Rules
- Define operation-specific input/output DTOs.
- Use state provider for queries (read).
- Use processor for commands (write).
- Keep entities internal; do not expose them directly as API resources.
- Keep operation-level security explicit (`security` expressions/voters).

## Serialization discipline
- Use minimal groups per operation.
- Avoid catch-all groups that leak internal fields.
- Version/deprecate contracts explicitly when behavior changes.

## Error contract
- Translate domain/application errors to stable API errors.
- Avoid leaking stack/internal class names.

## Done checklist
- Resource operation matrix updated.
- Provider/processor mapping clear.
- OpenAPI docs still coherent with real payloads.
- Functional tests cover at least one happy path and one denied/invalid path.
