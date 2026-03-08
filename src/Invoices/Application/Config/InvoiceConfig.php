<?php

declare(strict_types=1);

namespace App\Invoices\Application\Config;

final class InvoiceConfig
{
    public const SUBSCRIPTION_ID_LENGTH = 64;
    public const SUBSCRIPTON_TYPE_LENGTH = 32;
    public const BILLING_INTERVAL_LENGTH = 32;
    public const CUSTOMER_ID_LENGTH = 64;
    public const PRODUCT_ID_LENGTH = 64;
    public const PRODUCT_NAME_LENGTH = 255;
    public const PRICE_ID_LENGTH = 64;
    public const CANCELLATION_REASON_LENGTH = 255;
    public const STATUS_LENGTH = 32;
    public const LAST_EVENT_TYPE_LENGTH = 64;
}
