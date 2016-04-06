# Pagomío SDK PHP Library

## Installation

### Install with Composer

If you're using [Composer](https://github.com/composer/composer), add this to
your composer.json `require`:

```javascript
{
  "require" : {
    "pagomio/pagomio-sdk-php" : "dev-master"
  }
}
```

And load it using Composer's autoloader

```php
require 'vendor/autoload.php';
```

### Install from GitHub

To install the source code:

```bash
$ git clone git@github.com:Pagomio/pagomio-sdk-php.git
$ git clone git@github.com:rmccue/Requests.git
```
Include `pagomio-sdk-php` in your code and autoload `requests`:

```php
require_once '/path/to/pagomio-sdk-php/pagomio.php';
require_once '/path/to/Requests/library/Requests.php';
Requests::register_autoloader();
```

## Usage

### Set your client_id, secret_id and `true` if is sandbox:

```php
$pagomio = new Pagomio\Pagomio('client_id','secret_id',true);
```

### Generate Token
You must generate a token with all your payment information.

```php
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

// Url return to after payment - Is required
$enterpriseData = new Pagomio\EnterpriseData();
$enterpriseData->url_redirect = 'http://www.foo.com/response.php';
$enterpriseData->url_notify = 'http://www.foo.com/notify.php';

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
```

### Response 
After the payment `Pagomio.com` redirected to the page that you reported in the previous step.

```php
// response.php
$pagomio = new Pagomio\Pagomio('client_id','secret_id',true);
var_dump($pagomio->getRequestPayment());
```

## License
Licensed under the MIT license.

Copyright (r) 2015 Pagomío.
