<?php

declare(strict_types=1);

namespace Cocoders\BookingLoans\Domain\LoanBalance;

use Cocoders\BookingLoans\Domain\Money;

class Item
{
    /**
     * @var int
     */
    private $day;
    /**
     * @var Money
     */
    private $money;

    public function __construct(int $day, Money $money)
    {
        $this->day = $day;
        $this->money = $money;
    }

    public function money(): Money
    {
        return $this->money;
    }

    public function day(): int
    {
        return $this->day;
    }
}
