<?php

require_once 'CorreiosAbstract/CorreiosServices.php';
abstract class CorreiosRequest extends CorreiosService{

	
	private $webServiceUrl = 'http://ws.correios.com.br//calculador/CalcPrecoPrazo.asmx/CalcPrecoPrazo';
	protected $urlParams = '';
	
	
	protected function request($params = array()){
		echo $this->webServiceUrl . '?' . http_build_query($params);
		
		return TRUE;
	}
}