<?php

namespace Acruxx\Educacao\Matricula\Application\Ui;

use Acruxx\Educacao\Matricula\Domain\Repository\AlunoRepository;
use Acruxx\Educacao\Matricula\Domain\Repository\ClasseRepository;
use Acruxx\Educacao\Matricula\Domain\Repository\MatriculaRepository;
use Acruxx\Educacao\Matricula\Domain\Dto\MatriculaAlunoDto;
use Acruxx\Educacao\Matricula\Domain\Service\NovaMatriculaAluno;
use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Container\ContainerInterface;

final class MatriculaController
{

    /** @var ContainerInterface */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function show(Request $req, Response $res) : Response
    {
        /** @var AlunoRepository */
        $alunoRepository = $this->container->get(AlunoRepository::class);
        /** @var ClasseRepository */
        $classeRepository = $this->container->get(ClasseRepository::class);
        /** @var MatriculaRepository */
        $matriculaRepository = $this->container->get(MatriculaRepository::class);

        $alunos = $alunoRepository->findAll();
        $classes = $classeRepository->findAll();
        $matriculas = $matriculaRepository->findAll();

        $flashMessages = $this->container->flash->getMessages();

        return $this->container->view->render($res, 'matricula.html.twig', [
            'alunos' => $alunos,
            'classes' => $classes,
            'matriculas' => $matriculas,
            'formMessage' => $flashMessages['form_message'] ?? null
        ]);
    }

    public function insert(Request $req, Response $res) : Response
    {
        $novaMatriculaAlunoDto = MatriculaAlunoDto::fromArray($req->getParams());

        $this->container->get(NovaMatriculaAluno::class)->matricula($novaMatriculaAlunoDto);

        $this->container->flash->addMessage('form_message', 'Matricula criada com sucesso!');

        return $res->withRedirect('/matricula/nova');
    }
}
