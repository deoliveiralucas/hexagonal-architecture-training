<?php

namespace Acruxx\Educacao\Aluno\Domain\ValueObject;

use Assert\Assertion;

final class IdAluno
{

    /** @var string */
    private $id;

    private function __construct()
    {
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->id;
    }

    public static function fromString(string $id) : self
    {
        Assertion::string($id);
        Assertion::notBlank($id);

        $instance = new self();
        $instance->id = $id;
        return $instance;
    }

    public static function newInstance() : self
    {
        return static::fromString(\uniqid('', false));
    }
}
