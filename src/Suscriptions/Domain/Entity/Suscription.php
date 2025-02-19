<?php

declare(strict_types=1);

namespace App\Suscriptions\Domain\Entity;

use App\Suscriptions\Domain\Repository\SuscriptionRepository;
use App\Auth\Domain\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuscriptionRepository::class)]
#[ORM\Table(name: 'suscriptions')]
#[ORM\HasLifecycleCallbacks]
class Suscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_suscription', type: Types::BIGINT)]
    private ?int $idSuscription = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id_user', onDelete: 'CASCADE')]
    private User $user;

    //! Esta columna no tienen FK definidas
    #[ORM\Column(name: 'id_plan', type: Types::BIGINT)]
    private int $idPlan;

    //! Estas columnas no tienen FK definidas
    #[ORM\Column(name: 'id_payment', type: Types::BIGINT)]
    private int $idPayment;

    #[ORM\Column(name: 'start_date', type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $startDate = null;

    //! Falta calcular fecha de fin
    #[ORM\Column(name: 'end_date', type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $endDate;

    #[ORM\Column(name: 'is_active', type: Types::BOOLEAN, options: ['default' => true])]
    private bool $isActive = true;

    #[ORM\Column(name: 'create_at', type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(name: 'update_at', type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $updatedAt = null;

    // public function __construct()
    // {
    //     $this->startDate = new \DateTime();
    //     $this->createdAt = new \DateTime();
    //     $this->updatedAt = new \DateTime();
    // }

    #[ORM\PrePersist] // Se ejecuta antes de que la entidad se guarde por primera vez
    public function setTimestampsOnCreate(): void
    {
        $this->startDate = new \DateTimeImmutable();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate] // Se ejecuta antes de actualizar la entidad
    public function setTimestampsOnUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}
