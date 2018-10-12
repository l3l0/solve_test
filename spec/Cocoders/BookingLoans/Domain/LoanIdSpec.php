<?php

declare(strict_types=1);

namespace spec\Cocoders\BookingLoans\Domain;

use Cocoders\BookingLoans\Domain\LoanId;
use PhpSpec\ObjectBehavior;

/**
 * @mixin LoanId
 */
class LoanIdSpec extends ObjectBehavior
{
    function it_can_be_initialized_from_uuid_string()
    {
        $this->beConstructedThrough('fromString', ['ca4bcede-b134-450e-a0c9-7c80015bc0a9']);
        $this->shouldHaveType(LoanId::class);
    }

    function it_cannot_be_created_from_invalid_uuid()
    {
        $this->beConstructedThrough('fromString', ['123']);

        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }
}
