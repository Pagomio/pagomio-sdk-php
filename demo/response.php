<?php

require 'vendor/autoload.php';

$pagomio = new Pagomio\Pagomio('123456','123456',true);
var_dump($pagomio->getRequestPayment());