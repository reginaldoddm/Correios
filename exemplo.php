<?php 

/****SERVIÇOS DISPONIVEIS********
	40010 => 'Sedex',
	40045 => 'Sedex a cobrar',
	40215 => 'Sedex 10',
	40290 => 'Sedex hoje',
	41106 => 'PAC',
	81019 => 'E-sedex',
********************************/


require 'Correios.php';

try {
	
	$correios = new Correios('06851000', '06850040');
	$correios->autenticacaoContrato("xxxxxx", "xxxxxx");
	$correios->setPesoMedidas(0.300, 2, 11, 16);
	$correios->setServicos(array('40010', '41106', '81019'));
	$correios->setMaoPropria('N');
	$correios->setAvisoRecebimento('S');
	$correios->setFormato(1);
	$correios->setValorDeclarado(3.50);
	
	if($correios->consulta()=== FALSE){
		
		echo $consulta->getError();
		
	}else{
		
		echo '<pre>';
		var_dump($correios->getResult());
		echo '</pre>';
		
	}
	
} catch (Exception $e) {
	
	exit($e->getMessage());
	
}


?>