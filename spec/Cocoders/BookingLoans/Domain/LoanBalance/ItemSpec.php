<?php

declare(strict_types=1);

namespace spec\Cocoders\BookingLoans\Domain\LoanBalance;

use Cocoders\BookingLoans\Domain\LoanBalance\Item;
use Cocoders\BookingLoans\Domain\Money;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Item
 */
class ItemSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(1, Money::PLN('1000'));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Item::class);
        $this->money()->shouldBeLike(Money::PLN('1000'));
        $this->day()->shouldBe(1);
    }
}
