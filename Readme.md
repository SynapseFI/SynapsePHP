## Initialization

```php
from synapse_pay_rest import Client

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

  $options = array(
    "page" => 1,
    "per_page" => 1
    )
$allClientsTrans = $client->getAllClientTransactions([options]);
```

#### retrieve All User Transactions
```php
options = {
    "page" => 1,
    "per_page" => 1
}
    $allUserTrans = $client->getAllUserTransactions( $userObj, [options] );
```

#### Retrieve All Nodes

```php
  options = {
    "page" => 1,
    "per_page" => 1,
    "type" => ACH-US
  }
    $allNodes = $client->getAllNodes( $userObj, [options] );
```


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


##### Retrieve Subscription
```php
  
    $subscription = $client->getSubscription(  5bef6f1cb68b62009a5e0bb6' );
    
```

##### Retrieve Subscription
```php  

  $body= (object) [
  
  'url' => 'https://requestb.in/zp216zzp'
  ];
  
   $newSubscription = $client->createSubscription( body );
    
```

##### Update Subscription
```php  

  $body= (object) [
  'scope' => $scope_arr,
  'is_active' => false,
  'url' => 'https://requestb.in/zp216zzp'
  ];
  
   $updateSubscriptionObj = $client->updateSubscription( $subscriptionObj, $body );
    
```
