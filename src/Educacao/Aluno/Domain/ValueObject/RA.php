<?php

namespace Acruxx\Educacao\Aluno\Domain\ValueObject;

use Assert\Assertion;

final class RA
{

    /** @var string */
    private $ra;

    private function __construct()
    {
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->ra;
    }

    public static function fromString(string $ra) : self
    {
        Assertion::string($ra);
        Assertion::notBlank($ra);
        Assertion::length($ra, 11);

        $instance = new self();
        $instance->ra = $ra;
        return $instance;
    }
}
