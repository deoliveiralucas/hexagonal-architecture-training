```
CREATE TABLE IF NOT EXISTS alunos(
  id             VARCHAR(25) PRIMARY KEY,
  nome           VARCHAR(100),
  nome_mae       VARCHAR(100),
  ra             VARCHAR(15),
  arquivado      BOOLEAN,
  data_arquivado TIMESTAMP
);
```

```
CREATE TABLE IF NOT EXISTS matriculas(
  id             VARCHAR(25) PRIMARY KEY,
  id_aluno       VARCHAR(25),
  id_classe      VARCHAR(25),
  status         VARCHAR(25),
  data           TIMESTAMP
);
```

/*
    private $id;
    private $aluno;
    private $classe;
    private $status;
    private $data;
*/

/*
'id' => $aluno->getId()->toString(),
'nome' => $aluno->getNome()->toString(),
'nome_mae' => $aluno->getNomeMae()->toString(),
'ra' => $aluno->getRa()->toString(),
'arquivado' => $aluno->arquivado(),
'data_arquivado'
*/