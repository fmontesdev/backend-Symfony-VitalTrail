---
name: symfony-jwt-refresh-hardening
description: Implement secure JWT access/refresh lifecycle in Symfony APIs with rotation, revocation, and failure handling. Use when building or refactoring auth/session flows.
---

## Goal
Make token lifecycle predictable and safe for frontend + API integrations.

## Rules
- Keep access token short-lived.
- Rotate refresh token on refresh when possible.
- Invalidate revoked/rotated refresh tokens server-side.
- Return clear auth errors (`expired`, `invalid`, `revoked`) without leaking internals.
- Log auth security events for audit (refresh fail, reuse detection, forced logout).

## Flow
1. Login issues access + refresh token.
2. Refresh endpoint validates refresh token state.
3. On success, issue new access token (and rotated refresh token if enabled).
4. On failure/reuse detection, revoke session family and force re-auth.

## Done checklist
- Rotation/revocation behavior is deterministic.
- Concurrent refresh attempts handled safely.
- Logout invalidates refresh token path.
- Integration tests cover success + expired + revoked + replay cases.
