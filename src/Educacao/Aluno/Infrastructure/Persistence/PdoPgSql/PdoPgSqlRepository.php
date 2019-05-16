<?php

namespace Acruxx\Educacao\Aluno\Infrastructure\Persistence\PdoPgSql;

use Acruxx\Educacao\Aluno\Domain\Repository\AlunoRepository;
use Acruxx\Educacao\Aluno\Domain\Entity\Aluno;
use Acruxx\Educacao\Aluno\Domain\ValueObject\IdAluno;
use Acruxx\Educacao\Aluno\Domain\ValueObject\RA;
use Acruxx\Educacao\Aluno\Domain\Dto\CadastraAlunoDto;

class PdoPgSqlRepository implements AlunoRepository
{

    /** \PDO */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function store(Aluno $aluno) : void
    {
        if ($this->findByRA($aluno->getRA())) { /* deveria ser um findById */
            $stm = $this->pdo->prepare('
                UPDATE 
                    alunos
                SET
                    nome=:nome,
                    nome_mae=:nome_mae,
                    ra=:ra,
                    arquivado=:arquivado,
                    data_arquivado=:data_arquivado
                WHERE
                    id=:id
            ');
        } else {
            $stm = $this->pdo->prepare('
                INSERT INTO
                    alunos
                VALUES (
                    :id,
                    :nome,
                    :nome_mae,
                    :ra,
                    :arquivado,
                    :data_arquivado
                )
            ');
        }

        $dataArquivado = $aluno->getDataArquivado() ? $aluno->getDataArquivado()->format('Y-m-d H:i:s') : null;

        $id = $aluno->getId()->toString();
        $nome = $aluno->getNome()->toString();
        $nomeMae = $aluno->getNomeMae()->toString();
        $ra = $aluno->getRa()->toString();
        $arquivado = $aluno->arquivado();

        $stm->bindParam(':id', $id, \PDO::PARAM_STR);
        $stm->bindParam(':nome', $nome, \PDO::PARAM_STR);
        $stm->bindParam(':nome_mae', $nomeMae, \PDO::PARAM_STR);
        $stm->bindParam(':ra', $ra, \PDO::PARAM_STR);
        $stm->bindParam(':arquivado', $arquivado, \PDO::PARAM_BOOL);
        $stm->bindParam(':data_arquivado', $dataArquivado);

        $stm->execute();
    }

    public function getById(IdAluno $id) : Aluno
    {
        $id = $id->toString();

        $stm = $this->pdo->prepare('SELECT * FROM alunos WHERE id=:id');
        $stm->bindParam(':id', $id, \PDO::PARAM_STR);
        $stm->execute();

        $result = $stm->fetch(\PDO::FETCH_ASSOC);

        if (! is_array($result)) {
            throw new \RuntimeException(sprintf('Aluno com ID "%s" não existe', $id->toString()));
        }

        return $this->createAlunoFromArray($result);
    }

    public function findByRA(RA $ra) : ?Aluno
    {
        $ra = $ra->toString();

        $stm = $this->pdo->prepare('SELECT * FROM alunos WHERE ra=:ra');
        $stm->bindParam(':ra', $ra, \PDO::PARAM_STR);
        $stm->execute();

        $result = $stm->fetch(\PDO::FETCH_ASSOC);

        return is_array($result) ? $this->createAlunoFromArray($result) : null;
    }

    public function findAll() : array
    {
        $stm = $this->pdo->prepare('SELECT * FROM alunos');
        $stm->execute();

        $result = $stm->fetchAll(\PDO::FETCH_ASSOC);

        $alunos = [];
        foreach ($result as $alunoArr) {
            $alunos[] = $this->createAlunoFromArray($alunoArr);
        }

        return $alunos;
    }

    private function createAlunoFromArray(array $arrAluno) : Aluno
    {
        return Aluno::novoAluno(CadastraAlunoDto::fromArray($arrAluno), $arrAluno);
    }
}
