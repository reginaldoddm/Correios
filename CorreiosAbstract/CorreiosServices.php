<?php

/**
 * Classe abstrata que gerencia os serviços dos correios
 * serviços do tipo PAC, SEDEX, Mão própria, aviso de recebimento, etc
 * 
 * @author Reginaldo Moreira <reginaldoddm@gmail.com>
 * @package Correios
 * @copyright GPL General Public License 
 */
abstract class CorreiosService
{
    
    // variavél que armazena serviços disponíveis
    protected $codServico = array(
        40010 => 'Sedex',
        40045 => 'Sedex a cobrar',
        40215 => 'Sedex 10',
        40290 => 'Sedex hoje',
        41106 => 'PAC',
        81019 => 'E-Sedex'
    );

    protected $servicoParams = array();

    protected $maoPropria = 'N';

    protected $valorDeclarado = 0;

    protected $avisoRecebimento = 'N';

    /**
     * Adicione o serviço a ser consultado
     * 
     * @param mixed[] $servico  array('41106') ou com mais valores array('40010', '41106')
     * @throws \InvalidArgumentException
     * @return void
     */
    public function setServicos($servico = array())
    {
        if (! is_array($servico)) {
            throw new \InvalidArgumentException('O método ' . __METHOD__ . ' requer um parametro no formato array');
        }
        
        if (count($servico) <= 0) {
            throw new \InvalidArgumentException('O método ' . __METHOD__ . ' requer um parametro no formato array que não seja vazio');
        } else {
            
            foreach ($servico as $value) {
                if (! array_key_exists($value, $this->codServico)) {
                    
                    throw new \InvalidArgumentException('Serviço ' . $this->codServico[$value] . ' ' . $value . ' não está disponível');
                } else {
                    $this->servicoParams[] = $value;
                }
            }
        }
    }

    /**
     * Método que define a mão própria, se não utiliza o serviço de
     * mão própria do correio não e necessário utilizar este método.
     * 
     * @param string $string N para não S para sim
     * @return void
     */
    public function setMaoPropria($string = 'N')
    {
        $this->maoPropria = $string;
    }

    /**
     * Método que define o valor declarado, se não utiliza o serviço
     * do correio não e necessário utilizar este método.
     * 
     * @param int|double $valor
     * @return void
     */
    public function setValorDeclarado($valor = 0)
    {
        $this->valorDeclarado = number_format(str_replace(',', '.', $valor), 2, '.', ',');
    }

    /**
     * Método que define o aviso de recebimento, se não utiliza o serviço
     * do correio não e necessário utilizar este método.
     * 
     * @param string $string N para não S para sim
     * @return boolean
     */
    public function setAvisoRecebimento($string = 'N')
    {
        $this->avisoRecebimento = $string;
    }
}