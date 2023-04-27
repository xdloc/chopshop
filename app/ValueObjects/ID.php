<?php
declare(strict_types=1);

namespace App\ValueObjects;

class ID
{
    private int $value;

    /**
     * @param  int  $id
     */
    public function __construct(int $id)
    {
        $this->value = $id;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}