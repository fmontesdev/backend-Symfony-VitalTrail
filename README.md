# VitalTrail — Backend API

REST API for the VitalTrail outdoor activity platform, built with **Symfony 7.2** and **API Platform 4**. It follows Domain-Driven Design principles with Hexagonal Architecture (Ports & Adapters) and CQRS via Symfony Messenger.

---

## Tech Stack

| Layer | Technology |
|---|---|
| Language | PHP 8.3 |
| Framework | Symfony 7.2 |
| API | API Platform 4 |
| ORM | Doctrine ORM 3 + PostgreSQL |
| Auth | lexik/jwt-authentication-bundle + gesdinet/jwt-refresh-token-bundle |
| Bus | Symfony Messenger (command bus + query bus) |
| Containerization | Docker + Docker Compose |

---

## Requirements

- Docker & Docker Compose
- PHP 8.3 (for local development without Docker)
- Composer 2

---

## Getting Started

### 1. Clone and install dependencies

```bash
git clone <repo-url>
cd backend-Symfony-VitalTrail
composer install
```

### 2. Configure environment

Copy the example environment file and set your values:

```bash
cp .env .env.local
```

Key variables to configure in `.env.local`:

```dotenv
DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=16&charset=utf8"
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=your_passphrase
```

### 3. Generate JWT keys

```bash
php bin/console lexik:jwt:generate-keypair
```

### 4. Start services

```bash
docker compose up -d
```

This starts PostgreSQL. The API itself runs via PHP's built-in server:

```bash
php -S 0.0.0.0:8000 -t public/
```

Or using Docker directly (see `Dockerfile`):

```bash
docker build -t vitaltrail-backend .
docker run -p 8000:8000 vitaltrail-backend
```

### 5. Run database migrations

```bash
php bin/console doctrine:migrations:migrate
```

The API is now available at `http://localhost:8000/api`.

---

## Available Commands

```bash
# Install dependencies
composer install

# Start services (PostgreSQL via Docker)
docker compose up -d

# Start built-in PHP server
php -S 0.0.0.0:8000 -t public/

# Clear cache
php bin/console cache:clear

# Run database migrations
php bin/console doctrine:migrations:migrate

# Generate a new migration from entity changes
php bin/console doctrine:migrations:diff

# Validate Doctrine schema mappings
php bin/console doctrine:schema:validate

# Generate JWT key pair
php bin/console lexik:jwt:generate-keypair

# List all registered routes
php bin/console debug:router

# Inspect a service in the DI container
php bin/console debug:container <ServiceClass>
```

---

## Architecture

Each domain module lives under `src/<Module>/` and is split into four layers following the Hexagonal Architecture pattern:

```
src/<Module>/
├── Domain/          # Pure domain: Entities, Enums, OutputPort interfaces
├── Application/     # Use cases (CQRS), DTOs, InputPort interfaces, Services, Config
├── Infra/           # OutputAdapter implementations (Doctrine repositories)
└── Presentation/    # InputAdapter (API Platform Processors/Providers), Mappers, Resources
```

Cross-cutting shared code lives in `src/Shared/`.

### CQRS Flow

```
HTTP Request
    └── API Platform Resource (Presentation)
            └── Processor / Provider
                    └── ApplicationService::handle()
                            └── Symfony Messenger Bus
                                    └── CommandHandler / QueryHandler (Application)
                                            └── Domain Service / Repository
                                                    └── Doctrine (Infra)
```

1. The `Presentation` layer (Provider/Processor) receives the HTTP request and calls `ApplicationService::handle()`
2. `ApplicationServiceImpl` dispatches the message to the appropriate bus (`command.bus` or `query.bus`)
3. The handler (`#[AsMessageHandler]`) in `Application/UseCase/Command|Query` processes the business logic
4. Results flow back through the Presentation Mapper to an API Platform Resource

---

## Domain Modules

| Module | Description |
|---|---|
| `Auth` | User registration, login, JWT authentication, token refresh and revocation |
| `Profiles` | User profiles, follow/unfollow, avatar upload, achievements |
| `Routes` | Hiking/outdoor routes, categories, comments, ratings, favorites |
| `Sessions` | Active route sessions (start/end), wellbeing check-ins |
| `Notifications` | In-app notifications with per-user delivery and read state |
| `Stats` | Public platform statistics for the home page (cached 24 h) |
| `Admin` | Admin-only endpoints: user management, platform analytics |
| `Subscriptions` | User subscription plans |
| `Invoices` | Billing and invoice records |
| `Shared` | Cross-cutting: base commands/queries, exceptions, file uploads |
| `Security` | Custom JWT authenticator, SecurityContext, token blacklist |

---

## API Reference

### Authentication

All protected endpoints require a `Bearer` token in the `Authorization` header.

```
Authorization: Bearer <access_token>
```

| Method | Endpoint | Auth | Description |
|---|---|---|---|
| `POST` | `/api/users/register` | Public | Register a new user |
| `POST` | `/api/users/login` | Public | Login and receive JWT tokens |
| `GET` | `/api/user` | Required | Get current authenticated user |
| `PUT` | `/api/user` | Required | Update current user profile |
| `POST` | `/api/token/refresh` | Public | Refresh access token |
| `POST` | `/api/token/invalidate` | Required | Logout (revoke refresh token) |

### Profiles

| Method | Endpoint | Auth | Description |
|---|---|---|---|
| `GET` | `/api/profiles/{username}` | Required | Get a user profile |
| `GET` | `/api/profiles/{username}/followers` | Required | List followers |
| `GET` | `/api/profiles/{username}/following` | Required | List followed users |
| `PUT` | `/api/profiles/{username}/follow` | Required | Follow a user |
| `DELETE` | `/api/profiles/{username}/unfollow` | Required | Unfollow a user |
| `GET` | `/api/profiles/{username}/favorites` | Required | Get user's favorite routes |
| `POST` | `/api/profiles/{username}/avatar` | Required | Upload avatar image |

### Routes

| Method | Endpoint | Auth | Description |
|---|---|---|---|
| `GET` | `/api/routes` | Public | List routes (with filters) |
| `GET` | `/api/routes/{slug}` | Public | Get a single route |
| `POST` | `/api/routes` | Required | Create a route |
| `PUT` | `/api/routes/{slug}` | Required | Update a route |
| `DELETE` | `/api/routes/{slug}` | Required | Delete a route |
| `POST` | `/api/routes/{slug}/favorite` | Required | Add to favorites |
| `DELETE` | `/api/routes/{slug}/unfavorite` | Required | Remove from favorites |
| `GET` | `/api/routes/{slug}/comments` | Public | List comments |
| `POST` | `/api/routes/{slug}/comments` | Required | Add a comment |
| `DELETE` | `/api/comments/{id}` | Required | Delete a comment |
| `GET` | `/api/routes/{slug}/ratings` | Public | List ratings |
| `POST` | `/api/routes/{slug}/ratings` | Required | Rate a route |
| `DELETE` | `/api/routes/{slug}/ratings` | Required | Remove rating |

#### Route filters (`GET /api/routes`)

| Parameter | Type | Description |
|---|---|---|
| `category` | string | Filter by category title |
| `location` | string | Partial match on location |
| `title` | string | Partial match on title |
| `distance` | integer | Maximum distance (km) |
| `difficulty` | string | Difficulty level |
| `typeRoute` | string | Route type |
| `author` | string | Filter by author username |
| `sortBy` | string | `favoritesCount`, `createdAt`, `title`, `distance` |
| `order` | string | `asc` or `desc` |
| `limit` | integer | Results per page |
| `offset` | integer | Pagination offset |

### Sessions

| Method | Endpoint | Auth | Description |
|---|---|---|---|
| `GET` | `/api/sessions` | Required | List user sessions |
| `GET` | `/api/sessions/active` | Required | Get active session |
| `GET` | `/api/sessions/{id}` | Required | Get a specific session |
| `POST` | `/api/sessions` | Required | Start a new session |
| `PATCH` | `/api/sessions/{id}/end` | Required | Close a session |
| `DELETE` | `/api/sessions/{id}` | Required | Delete a session |
| `POST` | `/api/sessions/{id}/checkin` | Required | Register a wellbeing check-in |
| `GET` | `/api/sessions/{id}/checkin` | Required | Get check-in for a session |
| `GET` | `/api/checkins` | Required | List all user check-ins |

### Notifications

| Method | Endpoint | Auth | Description |
|---|---|---|---|
| `GET` | `/api/notifications/me` | Required | Get my notifications |
| `PATCH` | `/api/notifications/{id}/read` | Required | Mark notification as read |
| `PATCH` | `/api/notifications/read-all` | Required | Mark all as read |
| `POST` | `/api/notifications` | Admin only | Create a notification (broadcast) |
| `DELETE` | `/api/notifications/{id}` | Admin only | Delete a notification |

#### Automatic notifications (domain side-effects)

The system dispatches notifications automatically on these events:

| Event | Recipient | Type |
|---|---|---|
| User registers | New user | `welcome` |
| User creates a route | Route author | `route_created` |
| User comments on a route | Route author (not self) | `new_comment` |

### Stats

| Method | Endpoint | Auth | Description |
|---|---|---|---|
| `GET` | `/api/stats/home` | Public | Platform stats (24 h HTTP cache) |

### Admin

| Method | Endpoint | Auth | Description |
|---|---|---|---|
| `GET` | `/api/admin/stats` | Admin only | Platform analytics dashboard |
| `GET` | `/api/admin/users` | Admin only | Paginated user list |
| `GET` | `/api/admin/users/{id}` | Admin only | Get a specific user |

---

## Authentication Flow

```
POST /api/users/login
    └── Response: { access_token, refresh_token }

# Use access token (short-lived, ~1 hour)
Authorization: Bearer <access_token>

# Refresh when expired
POST /api/token/refresh
    Body: { refresh_token: "<refresh_token>" }
    └── Response: { access_token, refresh_token }

# Logout
POST /api/token/invalidate
    Body: { refresh_token: "<refresh_token>" }
    └── Blacklists both tokens
```

The API uses a **custom `PublicAwareJwtAuthenticator`** that allows public endpoints to be accessed without a token, while still resolving the user when a token is present.

---

## Error Handling

All errors are returned as JSON with a consistent format:

```json
{
    "error": "Human-readable error message"
}
```

The `ExceptionListener` catches all throwables and maps them to the appropriate HTTP status code. Domain exceptions extend `AbstractException` and pass the status code in the constructor:

```php
throw new RouteNotFoundException($slug); // returns 404
throw new UserIsNotAuthenticatedException(); // returns 401
```

---

## Project Structure

```
src/
├── Admin/               # Admin-only analytics and user management
├── Auth/                # Authentication, JWT, user registration/login
├── Invoices/            # Billing domain (in progress)
├── Notifications/       # In-app notification system
├── Profiles/            # User profiles, follows, achievements
├── Routes/              # Routes, comments, ratings, favorites
├── Security/            # JWT authenticator, SecurityContext, blacklist
├── Sessions/            # Route sessions and wellbeing check-ins
├── Shared/              # ApplicationService, base commands/queries, exceptions
├── Stats/               # Public platform statistics
├── Subscriptions/       # Subscription plans
└── Kernel.php

config/
├── packages/
│   ├── api_platform.yaml
│   ├── messenger.yaml   # command.bus + query.bus configuration
│   └── security.yaml    # Firewalls, access_control rules
├── jwt/                 # JWT private/public keys (not committed)
└── routes.yaml

migrations/              # Doctrine migration files
docker/                  # PHP configuration (php.ini)
public/                  # Web root (index.php)
```

---

## Code Conventions

### Every PHP file must start with

```php
<?php

declare(strict_types=1);

namespace App\Module\Layer\Sublayer;
```

### Naming

| Artifact | Convention | Example |
|---|---|---|
| Class / Interface | PascalCase | `ProfileService` |
| Method / Variable | camelCase | `findProfileSafe()` |
| Constants | UPPER_SNAKE_CASE | `ProfileConfig::OUTPUT_LIST` |
| DB column names | snake_case | `id_user`, `img_user` |
| Enum cases | UPPER_SNAKE_CASE | `RolUserEnum::ROLE_ADMIN` |
| Repository interface | `FooRepository` | `UserRepository` |
| Repository impl | `FooRepositoryImpl` | `UserRepositoryImpl` |
| API Platform Resource | `FooResource` | `ProfileResource` |
| DTO | `FooDto` | `ProfileDto` |
| Mapper | `FooMapper` | `ProfileMapper` |
| Config constants | `FooConfig` | `ProfileConfig` |
| Command / Query | `FooCommand`, `FooQuery` | `FollowCommand` |
| Handler | `FooCommandHandler`, `FooQueryHandler` | `FollowCommandHandler` |

### Dependency injection

Use constructor property promotion with `private readonly`:

```php
public function __construct(
    private readonly UserRepository $userRepository,
    private readonly SecurityContext $securityContext,
) {
}
```

### CQRS

- Commands implement `App\Shared\Application\Command\BaseCommand`
- Queries implement `App\Shared\Application\Query\BaseQuery`
- Handlers are annotated with `#[AsMessageHandler]`
- Never dispatch the bus directly from the Presentation layer — always go through `ApplicationService::handle()`

---

## Testing

No test suite is currently configured (PHPUnit is not installed). When added, tests should live in `tests/` with the `App\Tests\` namespace.

```bash
# Run all tests (once PHPUnit is installed)
php bin/phpunit

# Run a single test file
php bin/phpunit tests/Path/To/SomeTest.php

# Run a single test method
php bin/phpunit --filter testMethodName tests/Path/To/SomeTest.php
```

---

## License

Proprietary — all rights reserved.
