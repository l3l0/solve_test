<?php

declare(strict_types=1);

namespace Cocoders\BookingLoans\Domain;

use Cocoders\BookingLoans\Domain\Exception\CapitalAmountCannotBeNegative;
use Cocoders\BookingLoans\Domain\Exception\CapitalInterestAmountCannotBeNegative;
use Cocoders\BookingLoans\Domain\Exception\CommisionAmountCannotBeNegative;
use Cocoders\BookingLoans\Domain\Exception\PayOffAmountCannotBeNegative;
use Cocoders\BookingLoans\Domain\LoanBalance\Item;

class LoanBalance
{
    /**
     * @var LoanId
     */
    private $id;

    /**
     * @var Item[]
     */
    private $balance = [];
    /**
     * @var Money
     */
    private $dailyCapitalInterest;

    public function __construct(
        LoanId $id,
        Money $capital,
        Money $commision,
        Money $dailyCapitalInterest
    ) {
        if ($capital->isNegative()) {
            throw new CapitalAmountCannotBeNegative($capital . ' is negative');
        }

        if ($commision->isNegative()) {
            throw new CommisionAmountCannotBeNegative($commision . ' is negative');
        }

        if ($dailyCapitalInterest->isNegative()) {
            throw new CapitalInterestAmountCannotBeNegative($dailyCapitalInterest . ' is negative');
        }

        $this->id = $id;
        $this->balance[] = new Item(1, $capital);
        $this->balance[] = new Item(1, $commision);

        $this->dailyCapitalInterest = $dailyCapitalInterest;
    }

    public function balanceForDay(int $day): Money
    {
        $balance = $this->filterBalanceToDay($day);
        $balance = $this->addDailyCapitalInterestBalanceForEachDayTo($day, $balance);

        return $this->sumBalance($balance);
    }

    public function payOff(int $day, Money $paymentAmount): void
    {
        if ($paymentAmount->isNegative()) {
            throw new PayOffAmountCannotBeNegative($paymentAmount . ' passed');
        }
        $this->balance[] = new Item($day, $paymentAmount->negative());
    }

    /**
     * @return Item[]
     */
    private function filterBalanceToDay(int $day): array
    {
        $balance = array_filter(
            $this->balance,
            function (Item $item) use ($day) {
                return $item->day() <= $day;
            }
        );
        return $balance;
    }

    /**
     * @param Item[] $balance
     * @return Item[]
     */
    private function addDailyCapitalInterestBalanceForEachDayTo(int $day, array $balance): array
    {
        for ($i = 1; $i <= $day; $i++) {
            $balance[] = new Item($i, $this->dailyCapitalInterest);
        }
        return $balance;
    }

    /**
     * @param Item[] $balance
     * @return Money
     */
    private function sumBalance(array $balance): Money
    {
        return array_reduce($balance, function (Money $previous, Item $item) {
            return $previous->sum($item->money());
        }, Money::PLN('0'));
    }
}
