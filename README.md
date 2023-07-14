# mtn-mobile-money-sdk

php sdk for MTN MNO Mobile Money API

**Note:** `mtn-mobile-money-sdk`.

This is a php sdk for mtn operator mobile money api.

## Install

Via Composer

```bash
$ composer require foris-master/mtn-mobile-money-sdk
```

## Global Config

-  `MOMO_CURRENCY`  Setup  the currency  `value`: EUR

- `MOMO_SDK_ENV` Configures the value of the SDK environment `value`: sandbox  or  prod  
- `MOMO_ENV` variable to specify the application environment `value`: mtncameroon
- `MOMO_CALLBACK_HOST`Sets the callback host for MTN API notifications `value`:https://example.com  

- `MOMO_CALLBACK_URL` URL of the callback for MTN API notifications `value`: https://myawesome.callback.com
- enviroment variable ( .env file if using dotenv)
  
  
  

## Quick Usage

```php
use Foris\MoMoSdk\Disbursement;
use Foris\MoMoSdk\Collection;

        putenv('MOMO_CALLBACK_URL=https://myawesome.callback.com');
        putenv('MOMO_CALLBACK_HOST=azz.com');
        putenv('MOMO_ENV=mtncameroon');
        putenv('MOMO_SDK_ENV=prod');
        putenv('MOMO_CURRENCY=XAF');


Exemple  Disbursement
$disbursement = new Disbursement();
$disbursement->getAccessToken();
$disbursement->transfer(100, '0123456789');
$transferData = $disbursement->transfer(100, '0123456789');
$transactionData = $disbursement->getTransaction('transaction_id');
$balance = $disbursement->getBalance();
$accountValidation = $disbursement->isAccountValid('0123456789');

Exemple  Collection
$collection = new Collection();
$collection->getAccessToken();
$collection->requestToPay(100, '0123456789');
$collection-> getTransaction($id);
$collection->getBalance();
$collection->isAccountValid("0123456789")
```

## Config Disbursement

Disbursement is used for transferring money from the provider account to a customer [Read more about Momo Disbursement]( https://momodeveloper.mtn.com/docs/services/disbursement).

-  `MOMO_DISBURSEMENT_PRIMARY_KEY`   Primary Key for the Disbursement product on the developer portal  `value`: your primary key here
- `MOMO_DISBURSEMENT_API_USER` User for the Disbursement API `value`: Your appuser 
- `MOMO_DISBURSEMENT_APP_KEY` application key for the Disbursement product `value`: your app key



##  Disbursement Usage


- Get token

`getAccessToken()` This method allows you to obtain an access token to perform disbursement operations.

```php
use Foris\MoMoSdk\Disbursement;

$disbursement = new Disbursement();
$accessToken = $disbursement->getAccessToken();

```

- transfer

`transfer($amount, $tel, $options = array())` This method allows you to perform a funds transfer.


```php
use Foris\MoMoSdk\Disbursement;

$disbursement = new Disbursement();
$transferData = $disbursement->transfer(100, '0123456789');
```

- getTransaction


`getTransaction('transaction_id')`This method allows you to retrieve the details of a disbursement transaction.


```php
use Foris\MoMoSdk\Disbursement;

$disbursement = new Disbursement();
$transactionData = $disbursement->getTransaction('transaction_id');
```

-  getBalance

`getBalance()`This method allows you to get the balance of the disbursement account.

```php
use Foris\MoMoSdk\Disbursement;

$disbursement = new Disbursement();
$balance = $disbursement->getBalance();
```

- isAccountValid

`isAccountValid('0123456789')`This method allows you to check if a phone number is associated with a valid account. 
```php

use Foris\MoMoSdk\Disbursement;

$disbursement = new Disbursement();
$accountValidation = $disbursement->isAccountValid('0123456789');

```

## Config Collection

Collections is used for requesting a payment from a customer  and checking status of transactions [Read more about Momo Collection]( https://momodeveloper.mtn.com/docs/services/collection).

-  `MOMO_COLLECTION_PRIMARY_KEY`   Primary Key for the Collection product on the developer portal  `value`: your primary key here
- `MOMO_COLLECTION_API_USER` User for the Collection API `value`: Your appuser 
- `MOMO_COLLECTION_APP_KEY` application key for the Collection product `value`: your app key

## Collection Usage
Collections is used for requesting a payment from a customer  and checking status of transactions.

-  Get token

`getAccessToken()` This method allows you to obtain an access token to perform collection operations.
```php
use Foris\MoMoSdk\Collection;

$collection = new Collection();
$accessToken = $collection->getAccessToken();

```

- requestToPay

`requestToPay(100, '0123456789')` This method Initiates a payment request for a specific amount to the given phone number

```php



use Foris\MoMoSdk\CollectionCollection;

$collection = new CollectionCollection();
$requesPay = $collection->requestToPay(100, '0123456789');
```

- getTransaction

`getTransaction($id)` This method allows you to retrieve the details of a  transaction.

```php
use Foris\MoMoSdk\CollectionCollection;

$collection = new CollectionCollection();
$showTransaction = $collection->getTransaction($id);
```

- getBalance
`getBalance()`Retrieves the balance of the collection account

```php
use Foris\MoMoSdk\CollectionCollection;

$collection = new CollectionCollection();
$balance = $collection->getBalance();
```

- isAccountValid
`isAccountValid()`Checks if the given phone number is associated with a valid collection account

```php

use Foris\MoMoSdk\Collection;

$collection = new Collection();
$accountValidation = $collection->isAccountValid('0123456789');

```

#### Note

The status could take one of the following values: INITIATED; PENDING; EXPIRED; SUCCESS; FAILED

- INITIATED waiting for user entry
- PENDING user has clicked on “Confirmer”, transaction is in progress on Mtn side
- EXPIRED user has clicked on “Confirmer” too late (after token’s validity)
- SUCCESS payment is done
- FAILED payment has failed

## Production

```
  For production your need to set your target country code in COUNTRY enviroment variable ( .env file if using dotenv)
  example:  COUNTRY = mtncameroon
```

## Testing

```bash
$ vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/thephpleague/:package_name/blob/master/CONTRIBUTING.md) for details.

## Credits

- [foris-master](https://github.com/foris-master)
- [marlinbleriaux](https://github.com/marlinbleriaux)
- [All Contributors](https://github.com/thephpleague/:package_name/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.



