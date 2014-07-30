<?php
/**
 * Classe abstrata que é responsavél por se comunicar com o webservice dos correios
 * e tratar XML e retornar o resultado.
 * 
 * @author Reginaldo Moreira <reginaldoddm@gmail.com>
 * @package Correios
 * @copyright GPL General Public License 
 */

require_once 'CorreiosAbstract/CorreiosServices.php';
abstract class CorreiosRequest extends CorreiosService{

	
	private $webServiceUrl = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx/CalcPrecoPrazo';
	protected $urlParams = '';
	
	protected $errorString = '';
	
	private $resultCorreios = array();
	
	
	/**
	 * Método que se conecta com WebService dos correios 
	 * @param mixed[] $params
	 * @return boolean
	 */
	protected function request($params = array()){
		$url = $this->webServiceUrl . '?' . http_build_query($params);
		
		$ch = curl_init($url);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		
		$result = curl_exec($ch);
		$httpCodeResponse = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		curl_close($ch);
		
		//Checa
		if($httpCodeResponse == '200'){
			
			return ($this->readXML($result)) ? TRUE : FALSE;
			
		}else{
			
			$this->errorString = 'Sistema dos correios não responde.';
			
			return FALSE;
		}
	}
	
	
	/**
	 * Faz a leitura do xml dos correios
	 * e adiciona o resultado em um array
	 * @param string $xml XML dos correios
	 * @return void
	 */
	private function readXML($xml){
		$xml = simplexml_load_string($xml);
		
		//total de serviço
		$total = count($xml->Servicos->cServico);
		
		if($total > 0){
			
			$resultArray;
			
			$i = 0;
			foreach ($xml->Servicos->cServico as $key => $value){
				
				$resultArray[$i] = array(
					'codigo'                => (string)$value->Codigo,
					'servico'               => (string)$this->codServico["$value->Codigo"],
					'valor'                 => (string)$value->Valor,
					'prazoEntrega'          => (string)$value->PrazoEntrega,
					'valorMaoPropria'       => (string)$value->ValorMaoPropria,
					'valorAvisoRecebimento' => (string)$value->ValorAvisoRecebimento,
					'valorValorDeclarado'   => (string)$value->ValorValorDeclarado,
					'entregaDomiciliar'     => (string)$value->EntregaDomiciliar,
					'entregaSabado'         => (string)$value->EntregaSabado,
					'erro'                  => (string)$value->Erro,
					'msgErro'               => (string)$value->MsgErro,
					'valorSemAdicionais'    => (string)$value->ValorSemAdicionais,
					'obsFim'                => (string)$value->ObsFim
				);
				$i++;
			}
			
			$this->resultCorreios = $resultArray;
			
			return TRUE;
		}else{
			$this->errorString = 'O webservice não retornou nenhum resultado.';
			return FALSE;
			
		}
	}
	
	
	/**
	 * Retorna o resultado dos correios
	 * em um array
	 * @return mixed[]
	 */
	public function getResult(){
		return $this->resultCorreios;
	}
	
	/**
	 * Retorna a string do erro
	 * @return string
	 */
	public function getError(){
		return $this->errorString;
	}
}