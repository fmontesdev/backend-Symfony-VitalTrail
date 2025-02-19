<?php

declare(strict_types=1);

namespace App\Auth\Domain\Entity;

use App\Auth\Infra\OutputPort\ClientRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ORM\Table(name: 'clients')]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_client', type: Types::BIGINT)]
    private ?int $idClient = null;

    // Relación 1:1 -> "Client" es el lado propietario (owning side), ya que la tabla "clients" tiene la FK a "users".
    #[ORM\OneToOne(inversedBy: 'client', targetEntity: User::class, cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id_user', unique: true, onDelete: 'CASCADE')]
    private ?User $user;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone = null;

    public function getIdClient(): ?int
    {
        return $this->idClient;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }
}
