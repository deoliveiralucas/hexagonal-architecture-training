<?php

namespace Acruxx\Educacao\Matricula\Domain\ValueObject;

final class StatusMatricula
{

    public const MATRICULADO = 'matriculado';

    /** @var string */
    private $status;

    private function __construct()
    {
    }

    public function toString() : string
    {
        return $this->status;
    }

    public function matriculado() : self
    {
        $instance = new self;
        $instance->status = static::MATRICULADO;
        return $instance;
    }
}
