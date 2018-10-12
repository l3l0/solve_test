<?php

declare(strict_types=1);

namespace Cocoders\BookingLoans\Domain;

interface Settlement
{
    public function type(): string;
}
