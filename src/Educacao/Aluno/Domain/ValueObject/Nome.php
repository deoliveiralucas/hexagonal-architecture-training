<?php

namespace Acruxx\Educacao\Aluno\Domain\ValueObject;

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
        Assertion::string($nome);
        Assertion::notBlank($nome);
        Assertion::minLength($nome, 3);
        Assertion::maxLength($nome, 255);

        $instance = new self();
        $instance->nome = $nome;
        return $instance;
    }
}
