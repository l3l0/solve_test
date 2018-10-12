<?php

declare(strict_types=1);

namespace spec\Cocoders\BookingLoans\Domain;

use Cocoders\BookingLoans\Domain\Money;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Money
 */
class MoneySpec extends ObjectBehavior
{
    function it_is_initializable_using_pln()
    {
        $this->beConstructedThrough('PLN', ['466,65']);

        $this->shouldHaveType(Money::class);
    }

    function it_is_initializable_using_long_pln_am_pln()
    {
        $this->beConstructedThrough('PLN', ['100 230 466,65']);

        $this->shouldHaveType(Money::class);
    }

    function it_can_be_negative()
    {
        $this->beConstructedThrough('PLN', ['466,65']);

        $this->isNegative()->shouldBe(false);
        $money = $this->negative();
        $money->shouldBeLike(
            Money::PLN('-466.65')
        );
        $money->isNegative()->shouldBe(true);
    }

    function it_can_be_sum()
    {
        $this->beConstructedThrough('PLN', ['466,65']);

        $this->sum(Money::PLN('0.10'))->shouldBeLike(Money::PLN('466.75'));
        $this->sum(Money::PLN('-0.10'))->shouldBeLike(Money::PLN('466.55'));
    }
}
