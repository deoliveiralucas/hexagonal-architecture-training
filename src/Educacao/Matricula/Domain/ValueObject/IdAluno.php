<?php

namespace Acruxx\Educacao\Matricula\Domain\ValueObject;

use Assert\Assertion;

final class IdAluno
{

    /** @var string */
    private $id;

    private function __construct()
    {
    }

    public function toString() : string
    {
        return $this->id;
    }

    public static function fromString(string $id) : self
    {
        Assertion::notBlank($id);

        $instance = new self();
        $instance->id = $id;
        return $instance;
    }
}
