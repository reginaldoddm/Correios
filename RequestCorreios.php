<?php

namespace Correios;


class RequestCorreios {

    private $urlCalculateShipping = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx/CalcPrecoPrazo';

    /**
     * Envia a requisição para o webservice para calculo
     * @param Correios $correios
     * @param Package $package
     * @return bool|mixed
     */
    public function calculateShipping(Correios $correios, Package $package)
    {
        $params = [
            'nCdEmpresa'          => $correios->getCodeBusiness(),
            'sDsSenha'            => $correios->getPassword(),
            'sCepOrigem'          => $correios->getZipCodeSource(),
            'sCepDestino'         => $correios->getZipCodeDestination(),
            'nVlPeso'             => $package->getWeight(),
            'nCdFormato'          => $package->getFormat(),
            'nVlComprimento'      => $package->getLength(),
            'nVlAltura'           => $package->getHeight(),
            'nVlLargura'          => $package->getWidth(),
            'nVlDiametro'         => $package->getDiameter(),
            'sCdMaoPropria'       => $correios->getProperHand(),
            'nVlValorDeclarado'   => $correios->getDeclaredValue(),
            'sCdAvisoRecebimento' => $correios->getReceivingNotice(),
            'nCdServico'          => $correios->getCodeService()
        ];

        $url = $this->urlCalculateShipping . '?'.http_build_query($params);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $result = curl_exec($ch);
        $httpCodeResponse = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($httpCodeResponse != '200') {
            return false;
        }

        return $result;
    }
}