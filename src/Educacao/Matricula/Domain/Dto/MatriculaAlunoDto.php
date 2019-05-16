<?php

namespace Acruxx\Educacao\Matricula\Domain\Dto;

use Acruxx\Educacao\Matricula\Domain\ValueObject\IdAluno;
use Acruxx\Educacao\Matricula\Domain\ValueObject\IdClasse;

final class MatriculaAlunoDto
{

    /** @var IdAluno */
    private $idAluno;

    /** @var IdClasse */
    private $idClasse;

    private function __construct()
    {
    }

    public function getIdAluno() : IdAluno
    {
        return $this->idAluno;
    }

    public function getIdClasse() : IdClasse
    {
        return $this->idClasse;
    }

    public static function fromArray(array $params) : self
    {
        $instance = new self;
        $instance->idAluno = IdAluno::fromString($params['id_aluno'] ?? '');
        $instance->idClasse = IdClasse::fromString($params['id_classe'] ?? '');
        return $instance;
    }
}
