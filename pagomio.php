<?php

namespace Pagomio;

require_once "client.php";
require_once "beans/includes.php";

class Pagomio extends Client{

    public $client_id;
    public $secret_id;

    const TRANSACTION_PENDING = 1;
    const TRANSACTION_SUCCESS = 2;
    const TRANSACTION_ERROR = 3;

    /**
     * @param $client_id
     * @param $secret_id
     * @param bool $sandbox
     * @throws \Exception
     */
    public function __construct($client_id,$secret_id,$sandbox=false) {
        $this->client_id = $client_id;
        $this->secret_id = $secret_id;

        if($sandbox){
            $this->base_url = Client::BASE_URL_SANDBOX;
        }else{
            $this->base_url = Client::BASE_URL_PROD;
        }

        if (!$this->client_id || !$this->secret_id ) {
            throw new \Exception(Error_Message::ERROR_SECRET_ID);
        }
    }

    /**
     * @param AuthorizePayment $authorizePayment
     * @return ResponseToken
     * @throws \Exception
     */
    public function getToken(AuthorizePayment $authorizePayment){
        $authorizePayment->enterpriseData->client_id = $this->client_id;
        $authorizePayment->enterpriseData->secret_id = $this->secret_id;
        $object = array(
            'object' => base64_encode(serialize($authorizePayment))
        );
        return $this->request("POST", "/generates/tokens.json", $this->client_id, $this->secret_id,$object);
    }

    /**
     * @param null $reference
     * @return bool|array
     * @throws \Exception
     */
    public function getRequestPayment($reference=null){
        if(is_null($reference) && !isset($_REQUEST['reference'])){
            throw new \Exception(Error_Message::ERROR_NOT_REQUEST);
        }
        $reference = !is_null($reference) ? $reference : $_REQUEST['reference'];
        $object = array(
            'reference' => $reference
        );
        return $this->request("GET", "/transaction/info.json", $this->client_id, $this->secret_id,$object);
    }
}

?>
