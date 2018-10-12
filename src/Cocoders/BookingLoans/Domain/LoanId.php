<?php

declare(strict_types=1);

namespace Cocoders\BookingLoans\Domain;

use Ramsey\Uuid\Uuid;

final class LoanId
{
    /**
     * @var string
     */
    private $uuid;

    private function __construct(string $uuid)
    {
        if (!Uuid::isValid($uuid)) {
            throw new \InvalidArgumentException(sprintf('%s is not valid uuid', $uuid));
        }
        $this->uuid = $uuid;
    }

    public static function fromString(string $uuid): LoanId
    {
        return new LoanId($uuid);
    }

    public static function generateNew(): LoanId
    {
        return new LoanId((string) Uuid::uuid4());
    }
}
