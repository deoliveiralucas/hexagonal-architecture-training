<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Acruxx\Educacao\Aluno\Domain\Dto\CadastraAlunoDto;
use Acruxx\Educacao\Aluno\Domain\Service\CadastraAluno;
use Acruxx\Educacao\Aluno\Domain\Service\ArquivaAluno;
use Acruxx\Educacao\Aluno\Domain\ValueObject\IdAluno;
use Acruxx\Educacao\Aluno\Infrastructure\Persistence\Json\JsonAlunoRepository;

$storageDir = __DIR__ . '/../data/storage/';
$storageFile = 'alunos.json';

$alunoRepository = new JsonAlunoRepository($storageDir, $storageFile);

/**
 * Cadastra Aluno
 */
if (isset($_GET['nome'])) {
  try {
    $cadastraAlunoDto = CadastraAlunoDto::fromArray($_GET);
    $cadastraAluno = new CadastraAluno($alunoRepository);
    $cadastraAluno->cadastra($cadastraAlunoDto);
  } catch (\InvalidArgumentException $e) {
    printf('<p>Parâmetro inválido: "%s"</p>', $e->getMessage());
  } catch (\DomainException $e) {
    printf('<p>Problema de domínio: "%s"</p>', $e->getMessage());
  }
}

/**
 * Arquiva Aluno
 * http://localhost:8888/?arquiva_id=
 */
if (isset($_GET['arquiva_id'])) {
  $arquivoAluno = new ArquivaAluno($alunoRepository);
  $arquivoAluno->arquiva(IdAluno::fromString($_GET['arquiva_id']));

  echo '<p>Aluno arquivado com sucesso!<p>';
}

$alunos = $alunoRepository->findAll();

foreach ($alunos as $aluno) {
  $rowAluno = 'ID: ' . $aluno->getId()->toString() . ' - Nome: ' . $aluno->getNome()->toString() . '<hr />';

  if ($aluno->arquivado()) {
    echo '<strike>' . $rowAluno . '</strike>';
  } else {
    echo $rowAluno;
  }
}

echo '<br>Fim da execução';

/*
 | 1. Request http http://localhost:8888?nome=Ronaldo&nome_mae=Zidane&ra=12345678912
 | 2. index.php
 | 3. Atribuiu os dados da request para o DTO (Data Transfer Object)
 | 4. Criado a instancia do Service e chama o método "cadastra" atribuindo o DTO
*/
