<?php

declare(strict_types=1);

namespace App\Notifications\Domain\Entity;

use App\Auth\Domain\Entity\User;
use App\Notifications\Infra\OutputAdapter\Doctrine\NotificationsUsersRepositoryImpl;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationsUsersRepositoryImpl::class)]
#[ORM\Table(name: 'notifications_users')]
class NotificationsUsers
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Notification::class)]
    #[ORM\JoinColumn(name: 'id_notification', referencedColumnName: 'id_notification', onDelete: 'CASCADE')]
    private Notification $notification;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id_user', onDelete: 'CASCADE')]
    private User $user;

    #[ORM\Column(name: 'is_read', type: Types::BOOLEAN, options: ['default' => false])]
    private bool $isRead = false;

    #[ORM\Column(name: 'read_at', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $readAt = null;

    public function __construct(Notification $notification, User $user)
    {
        $this->notification = $notification;
        $this->user = $user;
    }

    public function getNotification(): Notification
    {
        return $this->notification;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function isRead(): bool
    {
        return $this->isRead;
    }

    public function setIsRead(bool $isRead): self
    {
        $this->isRead = $isRead;

        return $this;
    }

    public function getReadAt(): ?\DateTimeInterface
    {
        return $this->readAt;
    }

    public function setReadAt(?\DateTimeInterface $readAt): self
    {
        $this->readAt = $readAt;

        return $this;
    }
}
