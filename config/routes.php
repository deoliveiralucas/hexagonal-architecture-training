<?php

use Acruxx\Educacao\Aluno\Application\Rest;
use Acruxx\Educacao\Matricula\Application\Ui;

$app->post('/rest/v1/aluno', new Rest\CadastraAlunoAction($container));
$app->get('/rest/v1/aluno', new Rest\GetAlunosAction($container));
$app->put('/rest/v1/aluno', new Rest\ArquivaAlunoAction($container));
$app->get('/rest/v1/aluno/{id}', new Rest\GetAlunoAction($container));

$app->get('/matricula/nova', Ui\MatriculaController::class . ':show');
$app->post('/matricula/insert', Ui\MatriculaController::class . ':insert');