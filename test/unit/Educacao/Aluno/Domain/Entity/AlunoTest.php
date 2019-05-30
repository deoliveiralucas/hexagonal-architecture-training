<?php

namespace EducacaoUnitTest\Aluno\Domain\Service;

use Acruxx\Educacao\Aluno\Domain\Dto\CadastraAlunoDto;
use Acruxx\Educacao\Aluno\Domain\Entity\Aluno;
use Acruxx\Educacao\Aluno\Domain\Event\AlunoFoiCadastrado;
use Acruxx\Educacao\Aluno\Domain\Event\AlunoFoiArquivado;
use Acruxx\Educacao\Aluno\Domain\ValueObject\Nome;
use Acruxx\Educacao\Aluno\Domain\ValueObject\RA;
use Acruxx\Educacao\Aluno\Domain\ValueObject\NomeMae;
use PHPUnit\Framework\TestCase;

class AlunoTest extends TestCase
{

    /** array */
    private $paramsMockTest;

    /** @var MockObject */
    private $cadastraAlunoDto;

    public function setUp() : void
    {
        $this->paramsMockTest = [
            'nome' => Nome::fromString('NomeTest'),
            'ra' => RA::fromString('12345678910'),
            'nome_mae' => NomeMae::fromString('NomeMaeTest')
        ];

        $this->cadastraAlunoDto = $this
            ->getMockBuilder(CadastraAlunoDto::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->cadastraAlunoDto
            ->expects($this->once())
            ->method('getNome')
            ->willReturn($this->paramsMockTest['nome']);
        $this->cadastraAlunoDto
            ->expects($this->once())
            ->method('getRa')
            ->willReturn($this->paramsMockTest['ra']);
        $this->cadastraAlunoDto
            ->expects($this->once())
            ->method('getNomeMae')
            ->willReturn($this->paramsMockTest['nome_mae']);
    }

    /** @test */
    public function novoAlunoDeveFuncionarQuandoForDto() : void
    {
        $aluno = Aluno::novoAluno($this->cadastraAlunoDto);

        $this->assertNotNull($aluno->getId());
        $this->assertEquals($this->paramsMockTest['nome'], $aluno->getNome());
        $this->assertEquals($this->paramsMockTest['ra'], $aluno->getRa());
        $this->assertEquals($this->paramsMockTest['nome_mae'], $aluno->getNomeMae());
        
        $events = $aluno->releaseEvents();

        $this->assertTrue(count($events) > 0, 'Aluno não emitiu evento');
        $this->assertInstanceOf(AlunoFoiCadastrado::class, $events[0]);
    }

    /** @test */
    public function novoAlunoDeveFuncionarQuandoForArray() : void
    {
        $arrParamTest = [
            'id' => 'IdAluno0001',
            'arquivado' => true,
            'data_arquivado' => '2019-05-29'
        ];
        
        $aluno = Aluno::novoAluno($this->cadastraAlunoDto, $arrParamTest);

        $this->assertEquals($arrParamTest['id'], $aluno->getId()->toString());
        $this->assertEquals($arrParamTest['arquivado'], $aluno->arquivado());
        $this->assertEquals($arrParamTest['data_arquivado'], $aluno->getDataArquivado()->format('Y-m-d'));
        $this->assertCount(0, $aluno->releaseEvents(), 'Aluno não pode emitir evento quando criado por array');
    }

    /** @test */
    public function arquivaDeveFuncionar() : void
    {
        $aluno = Aluno::novoAluno($this->cadastraAlunoDto);

        $this->assertFalse($aluno->arquivado());
        $this->assertNull($aluno->getDataArquivado());

        $aluno->arquiva();

        $this->assertTrue($aluno->arquivado());
        $this->assertNotNull($aluno->getDataArquivado());

        $events = $aluno->releaseEvents();

        $this->assertTrue(count($events) > 0, 'Aluno não emitiu evento ao arquivar');
        $this->assertInstanceof(AlunoFoiArquivado::class, array_pop($events));
    }
}
