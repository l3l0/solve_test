<?php

declare(strict_types=1);

namespace Cocoders\BookingLoans\Domain;

use Cocoders\BookingLoans\Domain\Exception\SettlementsOrderCannotBeDetermined;

interface SettlementsOrder
{
    public function setPosition(int $position, string $settlementType): void;

    /**
     * Sorts settlement base on set position for given type.
     *
     * When you found in one of passed settlement, type which wasn't set by setPosition then this method should throws
     * SettlementsOrderCannotBeDetermined
     *
     * @throws SettlementsOrderCannotBeDetermined
     * @return Settlement[]
     */
    public function sort(Settlement ...$settlements): array;
}
