<?php
/**
 * Classe abstrata que gerencia os serviços dos correios
 * serviços do tipo PAC, SEDEX, Mão própria, aviso de recebimento, etc
 * 
 * @author Reginaldo Moreira <reginaldoddm@gmail.com>
 * @access public
 * @package Correios
 * @copyright GPL General Public License 
 */

abstract class CorreiosService{

	//variavál que armazena serviços disponíveis
	protected  $codServico = array(
			'SEDEX' => 40010,
			'SEDEX_COBRAR' => 40045,
			'SEDEX_10' => 40215,
			'SEDEX_HOJE' => 40290,
			'PAC' => 41106,
			'E_SEDEX' => 81019,
	);
}