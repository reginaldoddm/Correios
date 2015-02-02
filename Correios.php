<?php
/**
 * Classe responsável por calcular frete junto ao webservice dos correios
 * 
 * @author Reginaldo Moreira <reginaldoddm@gmail.com>
 * @version 1.0
 * @access public
 * @package Correios
 * @copyright GPL General Public License 
 */
require_once 'CorreiosAbstract/CorreiosRequest.php';

class Correios extends CorreiosRequest
{
	
	private $codeEmpresa = '';
	private $senha = '';
	
	private $cepOrigem;
	private $cepDestino;
	
	private $formato = 1;
	
    private $peso;
	private $comprimento;
	private $altura;
	private $largura;
	private $diametro;
	
	
	/**
	 * Adicione os CEP'S (origem e destino)
	 * @param string $cepOrigem CEP de Origem
	 * @param string $cepDestino CEP de Destino
	 * @throws \InvalidArgumentException
	 */
	public function __construct($cepOrigem = '', $cepDestino = '')
	{
		
		if (empty($cepOrigem) || empty($cepDestino)) {
			throw new \InvalidArgumentException('$cepOrigem e $cepDestino nao podem ser vazios');
		} else {
			
			$this->cepOrigem = preg_replace("/[^0-9]/", '', $cepOrigem);
			$this->cepDestino = preg_replace("/[^0-9]/", '', $cepDestino);
			
		}
		
	}
	
	
	/**
	 * Utilizar esse método se tiver contrato com o correios
	 * @param string $codeEmpresa número do contrato
	 * @param string $senha senha do contrato
	 * @return void
	 */
	public function autenticacaoContrato($codeEmpresa = '', $senha = '')
	{
		
		$this->codeEmpresa = $codeEmpresa;
		$this->senha = $senha;

	}
	
	
	/**
	 * Formato da encomenda (incluindo embalagem) adicione um valor inteiro
	 * @param int  $formato 1 = Formato caixa/pacote, 2 = Formato rolo/prisma, 3 = Envelope
	 * @return void
	 */
	public function setFormato($formato = 1)
	{
		$this->formato = (int)$formato;
	}
	
	
	/**
	 * Adicione peso e medidos da encomenda, se os valores forem menor que
	 * o padrão dos correios o método adiciona automaticamento o valor mínimo
	 * requerido pelo correios
	 * @param mixed int | double $peso
	 * @param int $altura
	 * @param int $largura
	 * @param int $comprimento
	 * @return void
	 */
	public function setPesoMedidas($peso = 0.300, $altura = 2, $largura = 11, $comprimento = 16)
	{
		$this->peso = ($peso < 0.300) ? 0.300 : $peso;
		$this->altura = ($altura < 2) ? 2 : $altura;
		$this->largura = ($largura < 11) ? 11 : $largura;
		$this->comprimento = ($largura < 16) ? 16 : $comprimento;
		
		$this->diametro = $this->altura + $this->largura;
	}
	
	
	/**
	 * <b>Método que realiza consulta</b> deve ser chamado após setar todos
	 * os parametros
	 * @return boolean
	 */
	public function consulta()
	{
		
		$params = array(
			'nCdEmpresa'          => $this->codeEmpresa,
			'sDsSenha'            => $this->senha,
			'sCepOrigem'          => $this->cepOrigem,
			'sCepDestino'         => $this->cepDestino,
			'nVlPeso'             => $this->peso,
			'nCdFormato'          => $this->formato,
			'nVlComprimento'      => $this->comprimento,
			'nVlAltura'           => $this->altura,
			'nVlLargura'          => $this->largura,
			'nVlDiametro'         => $this->diametro,
			'sCdMaoPropria'       => $this->maoPropria,
			'nVlValorDeclarado'   => $this->valorDeclarado,
			'sCdAvisoRecebimento' => $this->avisoRecebimento,
		);
		
		if (count($this->servicoParams) > 1) {
			$params['nCdServico'] = implode(',', $this->servicoParams);
		} else {
			$params['nCdServico'] = $this->servicoParams[0];
		}
	
		
		//Submit Request cUrl
		return ($this->request($params)) ? TRUE : FALSE;
			
	}
}