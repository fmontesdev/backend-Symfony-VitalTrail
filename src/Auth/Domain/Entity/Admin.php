<?php

declare(strict_types=1);

namespace App\Auth\Domain\Entity;

use App\Auth\Infra\OutputPort\AdminRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[ORM\Table(name: 'admins')]
class Admin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_admin', type: Types::BIGINT)]
    private ?int $idAdmin = null;

    // Relación 1:1 -> "Admin" es el lado propietario (owning side), ya que la tabla "admins" tiene la FK a "users".
    #[ORM\OneToOne(inversedBy: 'admin', targetEntity: User::class, cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id_user', unique: true, onDelete: 'CASCADE')]
    private ?User $user;

    public function getIdAdmin(): ?int
    {
        return $this->idAdmin;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
