<?php

declare(strict_types=1);

namespace App\Auth\Domain\Entity;

use App\Auth\Infra\OutputPort\BlacklistTokenRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BlacklistTokenRepository::class)]
#[ORM\Table(name: 'blacklist_tokens')]
class BlacklistToken
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_blacklist', type: Types::BIGINT)]
    private ?int $idBlacklist = null;

    #[ORM\Column(name: 'refresh_token', length: 500)]
    private ?string $refreshToken;

    public function getIdBlacklist(): ?int
    {
        return $this->idBlacklist;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function setRefreshToken(string $refreshToken): void
    {
        $this->refreshToken = $refreshToken;
    }
}
