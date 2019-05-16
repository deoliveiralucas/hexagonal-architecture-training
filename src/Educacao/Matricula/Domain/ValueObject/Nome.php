<?php

namespace Acruxx\Educacao\Matricula\Domain\ValueObject;

use Assert\Assertion;

final class Nome
{

    /** @var string */
    private $nome;

    private function __construct()
    {
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->nome;
    }

    public static function fromString(string $nome) : self
    {
        Assertion::notBlank($nome);

        $instance = new self();
        $instance->nome = $nome;
        return $instance;
    }
}
