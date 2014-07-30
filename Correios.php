<?php
/**
 * Classe responsável por calcular frete junto ao webservice dos correios
 * 
 * @author Reginaldo Moreira <reginaldoddm@gmail.com>
 * @version Beta
 * @access public
 * @package Correios
 * @copyright GPL General Public License 
 */
require_once 'CorreiosAbstract/CorreiosRequest.php';

class Correios extends CorreiosRequest{
	
	private $codeEmpresa = '';
	private $senha = '';
	
	private $servicoParams = array();
	
	private $cepOrigem;
	private $cepDestino;
	
	private $formato = 1;
	
	private $peso;
	private $comprimento;
	private $altura;
	private $largura;
	private $diametro;
	
	private $maoPropria = 'N';
	private $valorDeclarado = 0;
	private $avisoRecebimento = 'N';
	
	
	/**
	 * <b>Adicione os CEP'S</b> (origem e destino)
	 * @param string $cepOrigem CEP de Origem
	 * @param string $cepDestino CEP de Destino
	 * @throws \InvalidArgumentException
	 */
	public function __construct($cepOrigem = '', $cepDestino = ''){
		
		if(empty($cepOrigem) || empty($cepDestino)){
			throw new \InvalidArgumentException('$cepOrigem e $cepDestino nao podem ser vazios');
		}else{
			
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
	public function autenticacaoContrato($codeEmpresa = '', $senha = ''){
		
		$this->codeEmpresa = $codeEmpresa;
		$this->senha = $senha;

	}
	
	
	/**
	 * Formato da encomenda (incluindo embalagem) adicione um valor inteiro
	 * @param int  $formato 1 = Formato caixa/pacote, 2 = Formato rolo/prisma, 3 = Envelope
	 * @return void
	 */
	public function setFormato($formato = 1){
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
	public function setPesoMedidas($peso = 0.300, $altura = 2, $largura = 11, $comprimento = 16){
		$this->peso = ($peso < 0.300) ? 0.300 : $peso;
		$this->altura = ($altura < 2) ? 2 : $altura;
		$this->largura = ($largura < 11) ? 11 : $largura;
		$this->comprimento = ($largura < 16) ? 16 : $comprimento;
		
		$this->diametro = $this->altura + $this->largura;
	}
	
	
	/**
	 * Adicione o serviço a ser consultado 
	 * @param mixed $servico array('PAC') ou com mais valores array('SEDEX', 'PAC')
	 * @throws \InvalidArgumentException
	 * @return void
	 */
	public function setServicos($servico = array()){
		
		if(!is_array($servico)){
			throw new \InvalidArgumentException('O método '.__METHOD__.' requer um parametro no formato array');
		}
		
		if(count($servico) <= 0){
			throw new \InvalidArgumentException('O método '.__METHOD__.' requer um parametro no formato array que não seja vazio');
		}else{
			
			$erro = FALSE;
			foreach ($servico as $value){
				
				if(!array_key_exists($value, $this->codServico)){
					
					throw new \InvalidArgumentException('Serviço '. $value . ' não está disponível');
					
				}else{
					$this->servicoParams[] = $this->codServico[$value];
				}
				
			}
			
		}
	}
	

	
	/**
	 * Método que define a mão própria, se não utiliza o serviço de
	 * mão própria  do correio não e necessário utilizar este método.
	 * @param string $string N para não S para sim
	 * @return void
	 */
	public function setMaoPropria($string = 'N'){
		$this->maoPropria = $string;
	}	
		

	/**
	 * Método que define o valor declarado, se não utiliza o serviço
	 * do correio não e necessário utilizar este método.
	 * @param int|double $valor valor
	 * @return void
	 */
	public function setValorDeclarado($valor = 0){
		$this->valorDeclarado = number_format(str_replace(',','.', $valor), 2, '.', ',');
	}
	
	
	/**
	 * Método que define o aviso de recebimento, se não utiliza o serviço
	 * do correio não e necessário utilizar este método.
	 * @param string $string N para não S para sim
	 * @return boolean
	 */
	public function setAvisoRecebimento($string = 'N'){
		$this->avisoRecebimento = $string;
	}
	
	
	/**
	 * <b>Método que realiza consulta</b> deve ser chamado após setar todos
	 * os parametros
	 * @return boolean
	 */
	public function consulta(){
		
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
		
		if(count($this->servicoParams) > 1){
			$params['nCdServico'] = implode(',', $this->servicoParams);
		}else{
			$params['nCdServico'] = $this->servicoParams[0];
		}
	
		
		//Submit Request cUrl
		$this->request($params);
	}
}