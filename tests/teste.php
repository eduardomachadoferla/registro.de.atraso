<?php
 
use PHPUnit\Framework\TestCase;
 
class FormularioLoginTest extends TestCase
{
    private $html;
 
    protected function setUp(): void
    {
        // Carrega o conteúdo do form
        $this->html = file_get_contents('sosatraso/tests/teste.php'); 
    }
 
    public function testFormularioContemCamposEssenciais()
    {
        // Verifica se o campo de nome é obrigatório
        $this->assertTrue(strpos($this->html, 'input type="nome"') !== false);
        $this->assertTrue(strpos($this->html, 'name="nome"') !== false);
        $this->assertTrue(strpos($this->html, 'required') !== false);
 
        // Verifica se o campo turma está presente com opções esperadas
        $this->assertTrue(strpos($this->html, 'select id="turma"') !== false);
        $this->assertTrue(strpos($this->html, '<option value="INFANTIL I">INFANTIL I</option>') !== false);
        $this->assertTrue(strpos($this->html, '<option value="3º ENSINO MÉDIO">3º ENSINO MÉDIO</option>') !== false);
 
        // Verifica se o campo motivo do atraso está presente e tem as opções corretas
        $this->assertTrue(strpos($this->html, 'select id="motivo_atraso"') !== false);
        $this->assertTrue(strpos($this->html, '<option value="Perdi o horário">Perdi o horário</option>') !== false);
        $this->assertTrue(strpos($this->html, '<option value="Outro">Outro</option>') !== false);
    }
 
    public function testCaixaDeTextoEscondidaAposCarregamento()
    {
        // Verifica se a caixa de texto "outro_motivo" está oculta inicialmente
        $this->assertTrue(strpos($this->html, 'id="outro_motivo" class="hidden"') !== false);
    }
 
    public function testBotaoGerarBilhete()
    {
        // Verifica se o botão de submissão para gerar bilhete está presente e estilizado
        $this->assertTrue(strpos($this->html, 'button type="submit"') !== false);
        $this->assertTrue(strpos($this->html, 'GERAR BILHETE') !== false);
    }
}