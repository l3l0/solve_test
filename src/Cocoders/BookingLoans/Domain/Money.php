<?php

declare(strict_types=1);

namespace Cocoders\BookingLoans\Domain;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money as LibMoney;
use Money\Parser\DecimalMoneyParser;

final class Money
{
    /**
     * @var LibMoney
     */
    private $money;

    private function __construct(LibMoney $money)
    {
        $this->money = $money;
    }

    public static function PLN(string $amount): Money
    {
        $normalizedAmount = trim(str_replace(' ', '', str_replace(',', '.', $amount)));
        $moneyParser = new DecimalMoneyParser(new ISOCurrencies());

        return new Money(
            $moneyParser->parse($normalizedAmount, 'PLN')
        );
    }

    public function equals(Money $money): bool
    {
        return $this->money->equals($money->money);
    }

    public function negative(): Money
    {
        return new Money($this->money->negative());
    }

    public function sum(Money $money): Money
    {
        return new Money($this->money->add($money->money));
    }

    public function isNegative(): bool
    {
        return $this->money->isNegative();
    }

    public function __toString(): string
    {
        $numberFormatter = new \NumberFormatter('pl_PL', \NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, new ISOCurrencies());

        return $moneyFormatter->format($this->money);
    }
}
