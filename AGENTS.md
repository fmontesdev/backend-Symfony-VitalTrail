# AGENTS.md — VitalTrail Backend

Symfony 7.2 REST API (API Platform 4) following Domain-Driven Design with
Hexagonal Architecture (Ports & Adapters) and CQRS via Symfony Messenger.
PHP 8.3, PostgreSQL, JWT authentication (lexik/jwt-authentication-bundle).

---

## Build & Run Commands

```bash
# Install dependencies
composer install

# Start services (PostgreSQL via Docker)
docker compose up -d

# Built-in PHP server (development)
php -S 0.0.0.0:8000 -t public/

# Clear cache
php bin/console cache:clear

# Run database migrations
php bin/console doctrine:migrations:migrate

# Generate a new migration from entity changes
php bin/console doctrine:migrations:diff

# Validate Doctrine mappings
php bin/console doctrine:schema:validate
```

## Tests

No test suite is currently configured (PHPUnit is not installed).
When tests are added they should live in `tests/` with the `App\Tests\` namespace.
The Symfony test runner command will be:

```bash
# Run all tests (once PHPUnit is installed)
php bin/phpunit

# Run a single test file
php bin/phpunit tests/Path/To/SomeTest.php

# Run a single test method
php bin/phpunit --filter testMethodName tests/Path/To/SomeTest.php
```

## Linting & Static Analysis

No PHP CS Fixer or PHPStan configuration files exist yet. Follow the style
guidelines below manually until they are added. YAML linting is available:

```bash
vendor/bin/yaml-lint config/
```

---

## Project Architecture

Each domain module lives under `src/<Module>/` and is split into four layers:

```
src/<Module>/
├── Domain/          # Pure domain: Entities, Enums, OutputPort interfaces
├── Application/     # Use cases (CQRS), DTOs, InputPort interfaces, Services, Config
├── Infra/           # OutputAdapter implementations (Doctrine repositories)
└── Presentation/    # InputAdapter (API Platform Processors/Providers), Mappers, Resources
```

**Cross-cutting shared code** lives in `src/Shared/`.

### CQRS Flow

1. `Presentation` layer (Provider/Processor) calls `ApplicationService::handle()`
2. `ApplicationServiceImpl` dispatches to the appropriate Symfony Messenger bus
3. Handler (`#[AsMessageHandler]`) in `Application/UseCase/Command|Query` processes it
4. Result flows back through the Presentation Mapper to an API Platform Resource

---

## Code Style Guidelines

### Every PHP file

```php
<?php

declare(strict_types=1);

namespace App\Module\Layer\Sublayer;
```

`declare(strict_types=1)` is **mandatory** on every file.

### Imports

- One `use` statement per line, alphabetically grouped by namespace depth.
- No wildcard imports.
- Always use fully-qualified class names in `use` blocks; avoid inline `\Foo\Bar`.

### Classes

- One class/interface/enum per file, matching the filename exactly.
- `final` on classes that should not be extended (DTOs, Config constants, Resources).
- Entity classes are **not** final.

### Naming Conventions

| Artifact              | Convention                            | Example                        |
|-----------------------|---------------------------------------|--------------------------------|
| Class / Interface     | PascalCase                            | `ProfileService`               |
| Method / Variable     | camelCase                             | `findProfileSafe()`            |
| Constants             | UPPER_SNAKE_CASE                      | `ProfileConfig::OUTPUT_LIST`   |
| DB column names       | snake_case (via `ORM\Column(name:)`)  | `id_user`, `img_user`          |
| Enum cases            | UPPER_SNAKE_CASE                      | `RolUserEnum::ROLE_ADMIN`      |
| Repository interface  | `FooRepository` (no suffix)           | `UserRepository`               |
| Repository impl       | `FooRepositoryImpl`                   | `UserRepositoryImpl`           |
| API Platform Resource | `FooResource`                         | `ProfileResource`              |
| DTO                   | `FooDto`                              | `ProfileDto`                   |
| Mapper                | `FooMapper`                           | `ProfileMapper`                |
| Config constants      | `FooConfig`                           | `ProfileConfig`                |
| Command / Query       | `FooCommand`, `FooQuery`              | `FollowCommand`                |
| Handler               | `FooCommandHandler`, `FooQueryHandler`| `FollowCommandHandler`         |

### Dependency Injection

Use constructor property promotion with `private readonly` for all injected
services:

```php
public function __construct(
    private readonly UserRepository $userRepository,
    private readonly SecurityContext $securityContext,
) {
}
```

Trailing comma on the last constructor parameter is required.

### Entities & Doctrine

- IDs use `Symfony\Component\Uid\Uuid` generated in `__construct()`.
- All ORM mapping via PHP 8 attributes (`#[ORM\Entity]`, `#[ORM\Column]`, etc.).
- Setters return `self` for fluency.
- Collections are typed as `Doctrine\Common\Collections\Collection` and
  initialised as `ArrayCollection` in `__construct()`.
- Domain entities must **not** be registered as Symfony services (excluded in
  `services.yaml`).

### API Platform Resources & DTOs

- Resources (`Presentation/InputAdapter/Resource/`) carry only serialization
  metadata (`#[ApiResource]`, `#[Groups]`, `#[ApiProperty]`).
- DTOs (`Application/Dto/`) are plain `final` classes with public nullable
  properties and sensible defaults.
- Serialization groups are defined as string constants in `FooConfig` classes.

### CQRS

- Commands implement `App\Shared\Application\Command\BaseCommand`.
- Queries implement `App\Shared\Application\Query\BaseQuery`.
- Handlers are annotated with `#[AsMessageHandler]` and implement `__invoke()`.
- Dispatch through `ApplicationService::handle()`, never use the bus directly
  from Presentation.

### Error Handling

- All custom exceptions extend `App\Shared\Domain\Exception\AbstractException`.
- Pass the HTTP status code as the second constructor argument:

  ```php
  class ProfileNotFoundException extends AbstractException
  {
      public function __construct(?string $username)
      {
          parent::__construct('Profile "' . $username . '" does not exist', 404);
      }
  }
  ```

- `ExceptionListener` catches all throwables and returns a `JsonResponse` with
  `{"error": "<message>"}`. Do not build JSON error responses manually.
- Throw domain exceptions from the Application layer; never from Presentation.

### Formatting Rules

- 4-space indentation (no tabs).
- Opening brace for classes and methods on the **same line** is the project
  norm; `{` for control structures on the same line.
- No trailing whitespace.
- A single blank line between methods.
- Comments in Spanish are acceptable (existing code uses Spanish inline
  comments); prefer English for docblocks.
- PHPDoc `@param` / `@return` blocks are used on public methods when the type
  cannot be inferred from the signature alone (e.g. generics, array shapes).
  Template docblocks (`@extends`, `@implements`) are required on repository
  implementations.
