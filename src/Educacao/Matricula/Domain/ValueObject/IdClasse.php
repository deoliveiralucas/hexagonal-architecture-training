<?php

namespace Acruxx\Educacao\Matricula\Domain\ValueObject;

use Assert\Assertion;
use Ramsey\Uuid\Uuid;

final class IdClasse
{

    /** @var string */
    private $id;

    private function __construct()
    {
    }

    public function toString() : string
    {
        return $this->id->toString();
    }

    public function fromString(string $id) : self
    {
        Assertion::notBlank($id);

        $instance = new self;
        $instance->id = Uuid::fromString($id);
        return $instance;
    }
}
