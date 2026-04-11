<?php

declare(strict_types=1);

namespace App\Auth\Domain\OutputPort;

use App\Auth\Domain\Entity\User;

interface UserRepository
{
    public function findByEmail(string $email): ?User;
    public function findByUsername(string $username): ?User;
    public function save(User $user): void;
    public function countActiveClients(): int;
    public function countTotalUsers(): int;
    public function countPremiumUsers(): int;
    public function countNewUsersThisMonth(): int;
    /**
     * @return array<array{month: string, newUsers: int, newPremium: int}>
     */
    public function getUsersGrowthByMonth(int $months): array;

    public function findById(string $id): ?User;

    /**
     * @return User[]
     */
    public function findPaginatedForAdmin(int $page, int $limit, ?string $search, ?string $role, ?bool $isPremium, ?bool $isActive): array;

    public function countForAdmin(?string $search, ?string $role, ?bool $isPremium, ?bool $isActive): int;
}
