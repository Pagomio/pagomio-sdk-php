<?php

// With Composer
require 'vendor/autoload.php';

// From GitHub
require_once '/path/to/pagomio-sdk-php/pagomio.php';
require_once '/path/to/Requests/library/Requests.php';
Requests::register_autoloader();


$pagomio = new Pagomio\Pagomio('client_id','secret_id',true);

//Customer information - Not required
$userData = new Pagomio\UserData();
$userData->names = 'Name User';
$userData->lastNames = 'Last name User';
$userData->identificationType = 'CC'; # Allow: CC, TI, PT, NIT
$userData->identification = '123456789';
$userData->email = 'email@domain.com';

// Payment information - Is required
$paymentData = new Pagomio\PaymentData();
$paymentData->currency = 'COP';
$paymentData->reference = '1234';
$paymentData->totalAmount = '1160';
$paymentData->taxAmount = '160';
$paymentData->devolutionBaseAmount = '1000';
$paymentData->description = 'Description of your product';

// Url return to after payment
$enterpriseData = new Pagomio\EnterpriseData();
$enterpriseData->url_redirect = 'http://www.foo.com/response.php';

// Create the object
$aut = new Pagomio\AuthorizePayment();
$aut->enterpriseData = $enterpriseData;
$aut->paymentData = $paymentData;
$aut->userData = $userData;

// Generate the token
$response = $pagomio->getToken($aut);

// Redirect to Pagomio.com
if($response->success) {
    header("Location: " . $response->url);
}
