<?php
/**
 * Classe responsável por calcular frete junto ao webservice dos correios
 *
 * @author Reginaldo Moreira <reginaldoddm@gmail.com>
 * @version 2.0
 * @access public
 * @package Correios
 * @copyrighttt GPL General Public License
 */

namespace BravosWeb\Correios;


class Correios
{
    private $codeBusiness = '';
    private $password = '';

    private $zipCodeSource;
    private $zipCodeDestination;

    private $codesService = [
        40010 => 'Sedex',
        40045 => 'Sedex a cobrar',
        40215 => 'Sedex 10',
        40290 => 'Sedex hoje',
        41106 => 'PAC',
        81019 => 'E-Sedex'
    ];

    private $codeService;
    private $nameService;
    private $properHand = 'N';
    private $declaredValue = 0;
    private $receivingNotice = 'N';


    /**
     * @param $codeService
     * @return $this
     */
    public function setCodeService($codeService)
    {
        if (! array_key_exists($codeService, $this->codesService)) {
            throw new \InvalidArgumentException("this service $codeService not available");
        }

        $this->codeService = $codeService;
        $this->nameService = $this->codesService[$codeService];

        return $this;
    }

    /**
     * Mão própria S ou N
     * @param $string
     * @return $this
     */
    public function setProperHand($string = 'N')
    {
        $this->properHand = $string;
        return $this;
    }

    /**
     * @return string
     */
    public function getProperHand()
    {
        return $this->properHand;
    }


    /**
     * Aviso de recebimento S ou N
     * @param $string
     * @return $this
     */
    public function setReceivingNotice($string = 'N')
    {
        $this->receivingNotice = $string;
        return $this;
    }

    /**
     * @return string
     */
    public function getReceivingNotice()
    {
        return $this->receivingNotice;
    }

    /**
     * @param  float $value
     * @return $this
     */
    public function setDeclaredValue($value)
    {
        $this->declaredValue = number_format(str_replace(',', '.', $value), 2, '.', ',');
        return $this;
    }

    /**
     * @return int
     */
    public function getDeclaredValue()
    {
        return $this->declaredValue;
    }

    /**
     * @return string
     */
    public function getCodeService()
    {
        return $this->codeService;
    }

    /**
     * @return string
     */
    public function getNameService()
    {
        return $this->nameService;
    }

    /**
     * @return string
     */
    public function getZipCodeSource()
    {
        return $this->zipCodeSource;
    }

    /**
     * @param String $zipCodeSource
     * @return $this
     */
    public function setZipCodeSource($zipCodeSource)
    {
        if (empty($zipCodeSource)) {
            throw new \InvalidArgumentException('zipCodeSource can not be empty');
        }

        $this->zipCodeSource = preg_replace('/[^0-9]/', null, $zipCodeSource);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getZipCodeDestination()
    {
        return $this->zipCodeDestination;
    }

    /**
     * @param string $zipCodeDestination
     * @return $this
     */
    public function setZipCodeDestination($zipCodeDestination)
    {
        if (empty($zipCodeDestination)) {
            throw new \InvalidArgumentException('zipCodeDestination can not be empty');
        }

        $this->zipCodeDestination = preg_replace('/[^0-9]/', null, $zipCodeDestination);
        return $this;
    }

    /**
     * @return string
     */
    public function getCodeBusiness()
    {
        return $this->codeBusiness;
    }

    /**
     * @param String $codeBusiness
     * @return $this
     */
    public function setCodeBusiness($codeBusiness)
    {
        $this->codeBusiness = $codeBusiness;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Retorna array com todos serviços de entrega
     * @return array
     */
    public function getCodesService()
    {
        return $this->codesService;
    }



}