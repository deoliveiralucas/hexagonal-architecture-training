<?php

namespace Acruxx\Educacao\Aluno\Domain\Service;

use Acruxx\Educacao\Aluno\Domain\Dto\CadastraAlunoDto;
use Acruxx\Educacao\Aluno\Domain\Entity\Aluno;
use Acruxx\Educacao\Aluno\Domain\Repository\AlunoRepository;
use Acruxx\Educacao\Aluno\Domain\Event\Dispatcher;

class CadastraAluno
{

    /** @var AlunoRepository */
    private $alunoRepository;

    /** @var Dispatcher */
    private $dispatcher;

    public function __construct(AlunoRepository $alunoRepository, Dispatcher $dispatcher)
    {
        $this->alunoRepository = $alunoRepository;
        $this->dispatcher = $dispatcher;
    }

    public function cadastra(CadastraAlunoDto $cadastraAlunoDto) : void
    {
        $ra = $cadastraAlunoDto->getRa();

        if (null !== $this->alunoRepository->findByRa($ra)) {
            throw new \DomainException(sprintf('Aluno com RA "%s" já existe', $ra->toString()));
        }

        $aluno = Aluno::novoAluno($cadastraAlunoDto);

        $this->alunoRepository->store($aluno);

        $this->dispatcher->dispatch($aluno->releaseEvents());
    }
}
