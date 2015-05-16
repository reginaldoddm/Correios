Correios
========

Pacote de integração com os serviços dos Correios, calculo de endereço e busca de endereço por CEP.

**Como Usar?**

Calculo de frete:

<?php
//Use autoload
require 'Correios/Correios.php';
require 'Correios/Package.php';
require 'Correios/RequestCorreios.php';
require 'Correios/XMLRead.php';


use Correios\Correios;
use Correios\Package;
use Correios\XMLRead;
use Correios\RequestCorreios;

$correios = new Correios();
$correios->setZipCodeSource('01311300')
    ->setZipCodeDestination('06851040')
    ->setDeclaredValue(3.50)
    ->setProperHand('S')
    ->setCodeService('40010')
    ->setReceivingNotice('N');

$package = new Package();
$package->setFormat(1)
    ->setMediated(2, 11, 16)
    ->setWeight(1);

$request = new RequestCorreios();
$resultRequest = $request->calculateShipping($correios, $package);

if (! $resultRequest) {
    die('Erro ao consultar WebService');
}

$readXML = new XMLRead();
$xmlResult = $readXML->calculateShipping($resultRequest, $correios);

echo '<pre>';
var_dump($readXML->getResult());
echo '</pre>';
?>


**Busca de endereço**
require 'Correios/GetAddress.php';
use Correios\GetAddress;

$getAddress = new GetAddress('01311300');

echo '<pre>';
var_dump(json_decode($getAddress->getResponse()));
echo '</pre>';

