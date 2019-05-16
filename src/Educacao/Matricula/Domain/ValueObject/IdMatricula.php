<?php

namespace Acruxx\Educacao\Matricula\Domain\ValueObject;

use Assert\Assertion;
use Ramsey\Uuid\Uuid;

final class IdMatricula
{

    /** @var Uuid */
    private $id;

    private function __construct()
    {
    }

    public function toString() : string
    {
        return $this->id->toString();
    }

    public function create() : self
    {
        $instance = new self;
        $instance->id = Uuid::uuid4();
        return $instance;
    }

    public function fromString(string $id) : self
    {
        Assertion::notBlank($id);

        $instance = new self;
        $instance->id = Uuid::fromString($id);
        return $instance;
    }
}
