## SynapsePayRest-PHP

Simple API wrapper for SynapsePay v3 REST API.

<<<<<<< HEAD:synapse_rest/samples.md
$clientObj = (object) [
  'client_id:' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
  'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
  'ip_address' => '127.0.0.1',
  'fingerprint' => '|123456'
];
client = Client($clientObj);
```

#### Retrieve All Users

```php
No spaces in 'query' parameter
---------------
$options = array(
  "query" => 'BillGates',
  "page" => 1,
  "per_page" => 1,
  "show_refresh_tokens" => yes
)
$getUser = $client->getAllUsers([options]);

```

#### Retrieve User by ID

```php

    $getUser = $client->getUser('5bef6f1cb68b62009a5e0bb6');
```

#### Create a User

```php
$baseDoc = (object) [
  'login_obj' => $logins_obj
  'legal_names' => '$legal_names',
  'phone_number' => '$phone_number'
];
$newUser = $client->createUser($baseDoc);
```

#### Retrieve All Client Transactions
```php
=======
## Code Example
>>>>>>> 3bd509c7e8fadfd19b680732984f3a19f1bf72a3:Readme.md

Check out [samples.md](samples.md) and our [API documentation](http://docs.synapsepay.com/v3.1) for examples.

## Installation

**note**: we are temporarily using the package name "synapse_pay_rest_native" on composer, but you should still import `synapse_pay_rest` after installing it.
```bash
composer install synapse_pay_rest_native
```

<<<<<<< HEAD:synapse_rest/samples.md

##### Retrieve Institutions
```php
    $allInstitutions = $client->getInstitutions();

```

##### Retrieve All Subscriptions
```php

  options = {
    "page" => 1,
    "per_page" => 1
  }
    $allNodes = $client->getAllSubscriptions([options] );

```
=======
## Development
1. Clone the repo from GitHub.
2. Install requirements:
```bash
composer install -r requirements.txt
```

>>>>>>> 3bd509c7e8fadfd19b680732984f3a19f1bf72a3:Readme.md

## License

<<<<<<< HEAD:synapse_rest/samples.md
##### Retrieve Subscription
```php

    $subscription = $client->getSubscription(  5bef6f1cb68b62009a5e0bb6' );

```
=======
The MIT License (MIT)
>>>>>>> 3bd509c7e8fadfd19b680732984f3a19f1bf72a3:Readme.md

Copyright (c) 2017 Synapse Financial Technologies Inc.

<<<<<<< HEAD:synapse_rest/samples.md
  $body= (object) [

  'url' => 'https://requestb.in/zp216zzp'
  ];

   $newSubscription = $client->createSubscription( body );

```
=======
Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
the Software, and to permit persons to whom the Software is furnished to do so,
subject to the following conditions:
>>>>>>> 3bd509c7e8fadfd19b680732984f3a19f1bf72a3:Readme.md

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

<<<<<<< HEAD:synapse_rest/samples.md
  $body= (object) [
  'scope' => $scope_arr,
  'is_active' => false,
  'url' => 'https://requestb.in/zp216zzp'
  ];

   $updateSubscriptionObj = $client->updateSubscription( $subscriptionObj, $body );

```
=======
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
>>>>>>> 3bd509c7e8fadfd19b680732984f3a19f1bf72a3:Readme.md
