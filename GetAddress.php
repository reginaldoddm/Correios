<?php
	
namespace Correios;

class GetAddress
{
    
    private $response;
    
    /**
     * Busca endereço via cep
     * @param  string $zipCode código posta 
     * @return array
     */
    public function __construct($zipCode)
    {
        if (empty($zipCode)) {
            throw new \InvalidArgumentException('zipCode can not be empty');
        }

        $getAddress = new \SoapClient(null, 
            array(
                'location' => 'http://service.bravoswebdesign.com.br/service.php',
                'uri' => 'http://service.bravoswebdesign.com.br/',
                'trace' => 0,
                'encoding' => 'UTF-8'
            )
        );
        
        $response = $getAddress->getAddress(array('cep' => $zipCode));
        
        $this->response = (string)$response;
    }
    
    
    public function __toString()
    {
        return $this->response;
    }
}