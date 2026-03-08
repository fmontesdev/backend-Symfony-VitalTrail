<?php

declare(strict_types=1);

namespace App\Subscriptions\Domain\Entity;

use App\Auth\Domain\Entity\User;
use App\Subscriptions\Application\Config\SubscriptionConfig;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'subscriptions')]
#[ORM\HasLifecycleCallbacks] // Para que se activen los eventos del ciclo de vida de las entidades (PrePersist, PreUpdate, PostPersist, PostUpdate, PostRemove, PostLoad)
class Subscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT)]
    private ?int $id = null;

    #[ORM\Column(name: 'subscription_id', length: SubscriptionConfig::SUBSCRIPTION_ID_LENGTH, unique: true)]
    private ?string $subscriptionId = null;

    #[ORM\Column(name: 'subscription_type', length: SubscriptionConfig::SUBSCRIPTON_TYPE_LENGTH)]
    private ?string $subscriptionType = null;

    #[ORM\Column(name: 'billing_interval', length: SubscriptionConfig::BILLING_INTERVAL_LENGTH)]
    private ?string $billingInterval = null;

    #[ORM\ManyToOne(inversedBy: 'subscriptions', targetEntity: User::class, fetch: 'LAZY')]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id_user', nullable: false, onDelete: 'CASCADE')]
    private ?User $user = null;

    #[ORM\Column(name: 'customer_id', length: SubscriptionConfig::CUSTOMER_ID_LENGTH)]
    private ?string $customerId = null;

    #[ORM\Column(name: 'product_id', length: SubscriptionConfig::PRODUCT_ID_LENGTH)]
    private ?string $productId = null;

    #[ORM\Column(name: 'product_name', length: SubscriptionConfig::PRODUCT_NAME_LENGTH)]
    private ?string $productName = null;

    #[ORM\Column(name: 'price_id', length: SubscriptionConfig::PRICE_ID_LENGTH)]
    private ?string $priceId = null;

    #[ORM\Column(name: 'current_period_start', type: Types::INTEGER)]
    private ?int $currentPeriodStart = null;

    #[ORM\Column(name: 'current_period_end', type: Types::INTEGER)]
    private ?int $currentPeriodEnd = null;

    #[ORM\Column(name: 'cancel_at_period_end', type: Types::BOOLEAN, options: ['default' => false])]
    private bool $cancelAtPeriodEnd = false;

    #[ORM\Column(name: 'cancellation_reason', length: SubscriptionConfig::CANCELLATION_REASON_LENGTH, nullable: true)]
    private ?string $cancellationReason = null;

    #[ORM\Column(length: SubscriptionConfig::STATUS_LENGTH)]
    private ?string $status = null;

    #[ORM\Column(name: 'last_event_type', length: SubscriptionConfig::LAST_EVENT_TYPE_LENGTH)]
    private ?string $lastEventType = null;

    #[ORM\Column(name: 'create_at', type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(name: 'update_at', type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(name: 'payment_method_id', length: SubscriptionConfig::PAYMENT_METHOD_ID_LENGTH, nullable: true)]
    private ?string $paymentMethodId = null;

    #[ORM\Column(name: 'payment_method_type', length: SubscriptionConfig::PAYMENT_METHOD_TYPE_LENGTH, nullable: true)]
    private ?string $paymentMethodType = null;

    #[ORM\Column(name: 'card_brand', length: SubscriptionConfig::CARD_BRAND_LENGTH, nullable: true)]
    private ?string $cardBrand = null;

    #[ORM\Column(name: 'card_last4', length: SubscriptionConfig::CARD_LAST4_LENGTH, nullable: true)]
    private ?string $cardLast4 = null;

    #[ORM\Column(name: 'card_exp_month', type: Types::INTEGER, nullable: true)]
    private ?int $cardExpMonth = null;

    #[ORM\Column(name: 'card_exp_year', type: Types::INTEGER, nullable: true)]
    private ?int $cardExpYear = null;

    #[ORM\PrePersist] // Se ejecuta antes de que la entidad se guarde por primera vez
    public function setTimestampsOnCreate(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate] // Se ejecuta antes de actualizar la entidad
    public function setTimestampsOnUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    // Getters y setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubscriptionId(): ?string
    {
        return $this->subscriptionId;
    }

    public function setSubscriptionId(string $subscriptionId): self
    {
        $this->subscriptionId = $subscriptionId;
        return $this;
    }

    public function getSubscriptionType(): ?string
    {
        return $this->subscriptionType;
    }

    public function setSubscriptionType(string $subscriptionType): self
    {
        $this->subscriptionType = $subscriptionType;
        return $this;
    }

    public function getBillingInterval(): ?string
    {
        return $this->billingInterval;
    }

    public function setBillingInterval(string $billingInterval): self
    {
        $this->billingInterval = $billingInterval;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getCustomerId(): ?string
    {
        return $this->customerId;
    }

    public function setCustomerId(string $customerId): self
    {
        $this->customerId = $customerId;
        return $this;
    }

    public function getProductId(): ?string
    {
        return $this->productId;
    }

    public function setProductId(string $productId): self
    {
        $this->productId = $productId;
        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;
        return $this;
    }

    public function getPriceId(): ?string
    {
        return $this->priceId;
    }

    public function setPriceId(string $priceId): self
    {
        $this->priceId = $priceId;
        return $this;
    }

    public function getCurrentPeriodStart(): ?int
    {
        return $this->currentPeriodStart;
    }

    public function setCurrentPeriodStart(int $currentPeriodStart): self
    {
        $this->currentPeriodStart = $currentPeriodStart;
        return $this;
    }

    public function getCurrentPeriodEnd(): ?int
    {
        return $this->currentPeriodEnd;
    }

    public function setCurrentPeriodEnd(int $currentPeriodEnd): self
    {
        $this->currentPeriodEnd = $currentPeriodEnd;
        return $this;
    }

    public function isCancelAtPeriodEnd(): bool
    {
        return $this->cancelAtPeriodEnd;
    }

    public function setCancelAtPeriodEnd(bool $cancelAtPeriodEnd): self
    {
        $this->cancelAtPeriodEnd = $cancelAtPeriodEnd;
        return $this;
    }

    public function getCancellationReason(): ?string
    {
        return $this->cancellationReason;
    }

    public function setCancellationReason(string $cancellationReason): self
    {
        $this->cancellationReason = $cancellationReason;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getLastEventType(): ?string
    {
        return $this->lastEventType;
    }

    public function setLastEventType(string $lastEventType): self
    {
        $this->lastEventType = $lastEventType;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getPaymentMethodId(): ?string
    {
        return $this->paymentMethodId;
    }

    public function setPaymentMethodId(string $paymentMethodId): self
    {
        $this->paymentMethodId = $paymentMethodId;
        return $this;
    }

    public function getPaymentMethodType(): ?string
    {
        return $this->paymentMethodType;
    }

    public function setPaymentMethodType(string $paymentMethodType): self
    {
        $this->paymentMethodType = $paymentMethodType;
        return $this;
    }

    public function getCardBrand(): ?string
    {
        return $this->cardBrand;
    }

    public function setCardBrand(string $cardBrand): self
    {
        $this->cardBrand = $cardBrand;
        return $this;
    }

    public function getCardLast4(): ?string
    {
        return $this->cardLast4;
    }

    public function setCardLast4(string $cardLast4): self
    {
        $this->cardLast4 = $cardLast4;
        return $this;
    }

    public function getCardExpMonth(): ?int
    {
        return $this->cardExpMonth;
    }

    public function setCardExpMonth(int $cardExpMonth): self
    {
        $this->cardExpMonth = $cardExpMonth;
        return $this;
    }

    public function getCardExpYear(): ?int
    {
        return $this->cardExpYear;
    }

    public function setCardExpYear(int $cardExpYear): self
    {
        $this->cardExpYear = $cardExpYear;
        return $this;
    }
}
