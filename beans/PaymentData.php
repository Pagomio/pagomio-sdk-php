<?php

namespace Pagomio;

class PaymentData {

    /**
     * @var string
     */
    public $reference;

    /**
     * @var string
     */
    public $currency;

    /**
     * @var double
     */
    public $totalAmount;

    /**
     * @var double
     */
    public $taxAmount;

    /**
     * @var double
     */
    public $devolutionBaseAmount;

    /**
     * @var string
     */
    public $description;

}
