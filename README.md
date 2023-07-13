# mtn-mobile-money-sdk
php sdk for MTN  MNO Mobile Money API

**Note:**  `mtn-mobile-money-sdk`.


This is a php sdk for mtn operator mobile money api. 

## Install
Via Composer

``` bash
$ $ composer require foris-master/mtn-mobile-money-sdk
```

## Confing Collection

```
Set MOMO_CURRENCY, MOMO_SDK_ENV,MOMO_ENV,MOMO_CALLBACK_HOST,MOMO_COLLECTION_APP_KEY,MOMO_COLLECTION_API_USER,MOMO_CALLBACK_URL,MOMO_COLLECTION_PRIMARY_KEY enviroment variable ( .env file if using dotenv),
you get all related to you console at https://mtn
 ```



## Confing Disbursement

```
Set MOMO_CURRENCY, MOMO_SDK_ENV,MOMO_ENV,MOMO_CALLBACK_HOST,MOMO_DISBURSEMENT_APP_KEY, MOMO_DISBURSEMENT_API_USER,MOMO_CALLBACK_URL,MOMO_DISBURSEMENT_PRIMARY_KEY enviroment variable ( .env file if using dotenv),
you get all related to you console at https://mtn
 ```


##  Usage

``` php

use Foris\MoMoSdk\Disbursement;
use Foris\MoMoSdk\Collection;

// Exemple d'utilisation de la classe Disbursement
$disbursement = new Disbursement();
$disbursement->getAccessToken();
$disbursement->transfer(100, '0123456789');

// Exemple d'utilisation de la classe Collection
$collection = new Collection();
$collection->getAccessToken();
$collection->requestToPay(100, '0123456789');

```

## Disbursement

/**
 * You need to MOMO_CURRENCY, MOMO_SDK_ENV,MOMO_ENV,MOMO_CALLBACK_HOST,MOMO_DISBURSEMENT_APP_KEY, MOMO_DISBURSEMENT_API_USER,MOMO_CALLBACK_URL,MOMO_DISBURSEMENT_PRIMARY_KEY 
 * enviroment variable ( .env file if using dotenv)
 */
 
<!-- La classe Disbursement est utilisée pour effectuer des opérations de décaissement. -->

### Get token

``` php

getAccessToken()

// Cette méthode permet d'obtenir un jeton d'accès pour effectuer les opérations de décaissement.


use Foris\MoMoSdk\Disbursement;


$disbursement = new Disbursement();
$accessToken = $disbursement->getAccessToken();

```

### transfer

``` php

transfer($amount, $tel, $options = array())

// Cette méthode permet de faire un transfert de fonds.

use Foris\MoMoSdk\Disbursement;

$disbursement = new Disbursement();
$transferData = $disbursement->transfer(100, '0123456789');
```

### getTransaction

``` php


// Cette méthode permet d'obtenir les détails d'une transaction de décaissement.

use Foris\MoMoSdk\Disbursement;

$disbursement = new Disbursement();
$transactionData = $disbursement->getTransaction('transaction_id');
```

### getBalance

<!-- getBalance() -->
``` php
// Cette méthode permet d obtenir le solde du compte de décaissement.

$disbursement = new Disbursement();
$balance = $disbursement->getBalance();
```
### isAccountValid

``` php
isAccountValid($tel)

// Cette méthode permet de vérifier si un numéro de téléphone est associé à un compte valide.

use Foris\MoMoSdk\Disbursement;

$disbursement = new Disbursement();
$accountValidation = $disbursement->isAccountValid('0123456789');

```

## Classe Collection

<!-- La classe Collection est utilisée pour effectuer des opérations de collecte de fonds. -->

### Get token

``` php
getAccessToken()

// Cette méthode permet d'obtenir un jeton d'accès pour effectuer les opérations de décaissement.


use Foris\MoMoSdk\Collection;


$collection = new Collection();
$accessToken = $collection->getAccessToken();

```

### transfer

``` php

transfer($amount, $tel, $options = array())

// Cette méthode permet deffectuer un transfert de fonds.

use Foris\MoMoSdk\CollectionCollection;

$collection = new CollectionCollection();
$transferData = $collection->transfer(100, '0123456789');
```

### getTransaction

``` php


// Cette méthode permet d'obtenir les détails d'une transaction de décaissement.

use Foris\MoMoSdk\CollectionCollection;

$collection = new CollectionCollection();
$transactionData = $collection->getTransaction('transaction_id');
```

### getBalance

<!-- getBalance() -->
``` php
// Cette méthode permet d obtenir le solde du compte de décaissement.

$collection = new Collection();
$balance = $collection->getBalance();
```
### isAccountValid

``` php
isAccountValid($tel)

// Cette méthode permet de vérifier si un numéro de téléphone est associé à un compte valide.

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
  example : COUNTRY=cm
```
## Testing

``` bash
$ phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/thephpleague/:package_name/blob/master/CONTRIBUTING.md) for details.

## Credits
- [foris-master](https://github.com/foris-master)
- [All Contributors](https://github.com/thephpleague/:package_name/contributors)


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.



