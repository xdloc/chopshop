<?php
declare(strict_types=1);

namespace App\ValueObjects;

class Name
{
    private string $value;

    /**
     * @param  string  $name
     */
    public function __construct(string $name)
    {
        $this->value = $name;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}