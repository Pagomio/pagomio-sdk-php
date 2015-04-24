<?php

require 'vendor/autoload.php';

$pagomio = new Pagomio\Pagomio('123456','123456',true);

$userData = new Pagomio\UserData();
$userData->names = 'Name User';
$userData->lastNames = 'Last name User';
$userData->identificationType = 'CC';
$userData->identification = '123456789';
$userData->email = 'email@dominio.com';

$paymentData = new Pagomio\PaymentData();
$paymentData->currency = 'COP';
$paymentData->reference = '1234';
$paymentData->totalAmount = '1160';
$paymentData->taxAmount = '160';
$paymentData->devolutionBaseAmount = '1000';
$paymentData->description = '';

$enterpriseData = new Pagomio\EnterpriseData();
$enterpriseData->url_redirect = 'http://www.foo.com/response.php';

$aut = new Pagomio\AuthorizePayment();
$aut->enterpriseData = $enterpriseData;
$aut->paymentData = $paymentData;
$aut->userData = $userData;

$response = $pagomio->getToken($aut);
if($response->success) {
    header("Location: " . $response->url);
}