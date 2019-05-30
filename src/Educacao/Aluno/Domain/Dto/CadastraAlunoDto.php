<?php

namespace Acruxx\Educacao\Aluno\Domain\Dto;

use Acruxx\Educacao\Aluno\Domain\ValueObject\Nome;
use Acruxx\Educacao\Aluno\Domain\ValueObject\NomeMae;
use Acruxx\Educacao\Aluno\Domain\ValueObject\RA;
use Assert\Assertion;

class CadastraAlunoDto
{

    /** @var Nome */
    private $nome;

    /** @var RA */
    private $ra;

    /** @var NomeMae */
    private $nomeMae;

    private function __construct()
    {
    }

    /**
     * @return Nome
     */
    public function getNome(): Nome
    {
        return $this->nome;
    }

    /**
     * @return RA
     */
    public function getRa(): RA
    {
        return $this->ra;
    }

    /**
     * @return NomeMae
     */
    public function getNomeMae(): NomeMae
    {
        return $this->nomeMae;
    }

    public static function fromArray(array $params) : self
    {
        Assertion::keyIsset($params, 'nome');
        Assertion::keyIsset($params, 'ra');
        Assertion::keyIsset($params, 'nome_mae');

        $instance = new self();
        $instance->nome = Nome::fromString($params['nome']);
        $instance->ra = RA::fromString($params['ra']);
        $instance->nomeMae = NomeMae::fromString($params['nome_mae']);

        return $instance;
    }
}
