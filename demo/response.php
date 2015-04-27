<?php

require 'vendor/autoload.php';

$pagomio = new Pagomio\Pagomio('client_id','secret_id',true);
var_dump($pagomio->getRequestPayment());