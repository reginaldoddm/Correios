<?php

abstract class CurlRequest{
	
	//variavél que armazena serviços disponíveis
	protected  $codServico = array(
			'SEDEX' => 40010,
			'SEDEX_COBRAR' => 40045,
			'SEDEX_10' => 40215,
			'SEDEX_HOJE' => 40290,
			'PAC' => 41106,
			'E_SEDEX' => 81019,
	);
	
	private $webServiceUrl = 'http://ws.correios.com.br//calculador/CalcPrecoPrazo.asmx/CalcPrecoPrazo';
	
	protected $urlParams = '';
	
	
	protected function request($params = array()){
		echo $this->webServiceUrl . '?' . http_build_query($params);
		
		return TRUE;
	}
}