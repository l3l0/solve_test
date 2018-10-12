<?php

declare(strict_types=1);

namespace spec\Cocoders\BookingLoans\Domain;

use Cocoders\BookingLoans\Domain\LoanBalance;
use Cocoders\BookingLoans\Domain\LoanId;
use Cocoders\BookingLoans\Domain\Money;
use Cocoders\BookingLoans\Domain\Exception\PayOffAmountCannotBeNegative;
use Cocoders\BookingLoans\Domain\Exception\CapitalAmountCannotBeNegative;
use Cocoders\BookingLoans\Domain\Exception\CapitalInterestAmountCannotBeNegative;
use Cocoders\BookingLoans\Domain\Exception\CommisionAmountCannotBeNegative;
use PhpSpec\ObjectBehavior;

/**
 * @mixin LoanBalance
 */
class LoanBalanceSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            LoanId::generateNew(),
            Money::PLN('1700'),
            Money::PLN('466.65'),
            Money::PLN('0.45')
        );
    }

    function it_gets_balance_for_days_without_pay_off()
    {
        $this->balanceForDay(1)->shouldBeLike(Money::PLN('2167.10'));
        $this->balanceForDay(2)->shouldBeLike(Money::PLN('2167.55'));
        $this->balanceForDay(3)->shouldBeLike(Money::PLN('2168'));
    }

    function it_gets_balance_after_payoff()
    {
        $this->payOff(3, Money::PLN('1000'));

        $this->balanceForDay(1)->shouldBeLike(Money::PLN('2167.10'));
        $this->balanceForDay(2)->shouldBeLike(Money::PLN('2167.55'));
        $this->balanceForDay(3)->shouldBeLike(Money::PLN('1168'));
        $this->balanceForDay(4)->shouldBeLike(Money::PLN('1168.45'));
    }

    function its_pay_off_cannot_be_done_with_negative_amount()
    {
        $this->shouldThrow(PayOffAmountCannotBeNegative::class)->duringPayOff(3, Money::PLN('-1000'));
    }

    function it_cannot_be_initialized_with_negative_capital_amount()
    {
        $this->beConstructedWith(
            LoanId::generateNew(),
            Money::PLN('-1700'),
            Money::PLN('466.65'),
            Money::PLN('0.45')
        );

        $this->shouldThrow(CapitalAmountCannotBeNegative::class)->duringInstantiation();
    }

    function it_cannot_be_initialized_with_negative_commision_amount()
    {
        $this->beConstructedWith(
            LoanId::generateNew(),
            Money::PLN('1700'),
            Money::PLN('-466.65'),
            Money::PLN('0.45')
        );

        $this->shouldThrow(CommisionAmountCannotBeNegative::class)->duringInstantiation();
    }

    function it_cannot_be_initialized_with_negative_daily_capital_interest_amount()
    {
        $this->beConstructedWith(
            LoanId::generateNew(),
            Money::PLN('1700'),
            Money::PLN('466.65'),
            Money::PLN('-0.45')
        );

        $this->shouldThrow(CapitalInterestAmountCannotBeNegative::class)->duringInstantiation();
    }
}
