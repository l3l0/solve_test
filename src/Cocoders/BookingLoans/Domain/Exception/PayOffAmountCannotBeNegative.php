<?php

declare(strict_types=1);

namespace Cocoders\BookingLoans\Domain\Exception;

use InvalidArgumentException;

final class PayOffAmountCannotBeNegative extends InvalidArgumentException
{
}
