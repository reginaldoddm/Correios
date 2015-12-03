<?php

namespace BravosWeb\Correios;

class Address
{
    private $response;
    private $soap;


    public function __construct(ConnectSoap $connectSoap)
    {
        $this->soap = $connectSoap;
    }
    
    /**
     * Busca endereço via cep
     * @param  string $zipCode código postal
     * @return string Json encode
     */
    public function getAddressByZipcode($zipCode)
    {
        if (empty($zipCode)) {
            throw new \InvalidArgumentException('zipCode can not be empty');
        }

        $soap = $this->soap;
        
        $response = $soap->getAddress(array('cep' => $zipCode));
        
        $this->response = (string)$response;
    }
    
    public function __toString()
    {
        return $this->response;
    }
}