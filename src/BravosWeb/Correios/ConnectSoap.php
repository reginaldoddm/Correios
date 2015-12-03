<?php
namespace BravosWeb\Correios;


class ConnectSoap
{

    public function __construct()
    {
        $soap = new \SoapClient(null,
            array(
                'location' => 'http://service.bravoswebdesign.com.br/service.php',
                'uri' => 'http://service.bravoswebdesign.com.br/',
                'trace' => 0,
                'encoding' => 'UTF-8'
            )
        );

        return $soap;
    }

}