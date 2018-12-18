## Initialization

```php
from synapse_pay_rest import Client

$clientObj = (object) [
   'client_id' => 'your_client_id',
   'client_secret' => 'your_client_secret',
   'fingerprint' => '|your_finger_print',
   'ip_address' => 'your_ip_address',
   'devmode' => True,
   'printToConsole' => True,
   'handle202' => True
];
client = Client($clientObj);
```

#### Get All Users on Platform

```php
All these params are optional. Set the arguments as null to exclude them.
---------------
$query = 'test';
$page = 1;
$per_page = 1;
$show_refresh = 'yes';
$allusers = $client->get_all_users($query, $page, $per_page, $show_refresh);
```

#### Create a User
```php
Body is required and idempotency key is optional. Idempotency key is set to null by default.
---------------
$body = (object) [
  'login_obj' => $logins_obj
  'legal_names' => '$legal_names',
  'phone_number' => '$phone_number'
];

$idempotency_key = 'your_idempotency_key';
$newuser = $client->create_user($body, $idempotency_key);
```

#### Get a Single User on Platform
```php
Userid is required and full_dehydrate is optional. Full_dehydrate is set to null by default.
---------------
$full_dehydrate = 'yes';  
$user = $client->get_user('your_user_id', $full_dehydrate);
```

#### Add New Documents
```php
Body is required.
---------------
$body = array (
  'documents' =>
  array (
    array (
      'email' => 'test3@synapsefi.com',
      'phone_number' => '901.111.1111',
      'ip' => '::1',
      'name' => 'Test User',
      'alias' => 'Test',
      'entity_type' => 'M',
      'entity_scope' => 'Arts & Entertainment',
      'day' => 2,
      'month' => 5,
      'year' => 1989,
      'address_street' => '1 Market St.',
      'address_city' => 'San Francisco',
      'address_subdivision' => 'CA',
      'address_postal_code' => '94114',
      'address_country_code' => 'US',
      'virtual_docs' =>
      array (
        array (
          'document_value' => '2222',
          'document_type' => 'SSN',
        ),
      ),
      'physical_docs' =>
      array (
        array (
          'document_value' => 'data:image/gif;base64,SUQs==',
          'document_type' => 'GOVT_ID',
        ),
      ),
      'social_docs' =>
      array (
        array (
          'document_value' => 'https://www.facebook.com/valid',
          'document_type' => 'FACEBOOK',
        ),
      ),
    ),
  ),
);
$user = $client->update_info($body);
```

#### Update Existing Documents
```php
Body is required.
---------------
$body = array (
  'documents' =>
  array (
    array (
      'id' => 'your_updated_id',
      'email' => 'test2@synapsefi.com'
    )
  )
);
$user = $client->update_info($body);
```


#### Get All Platform/Client Transactions
```php
No arguments are required. Set $page and $per_page as null to exclude it.
---------------
$page = 1;
$per_page = 1;

$allclienttrans = $client->get_all_transactions($page=null, $per_page=null);
```

#### Get All User Transactions
```php
No arguments are required. $page and $per_page are set to null by default.
---------------
$userid = 'your_user_id';
$user = $client->get_user($userid);
$page = 1;
$per_page = 1;

$allusertrans = $user->get_all_transactions( $page, $per_page );
```

#### Get All Node Transactions
```php
Nodeid is required. $page and $per_page are set to null by default.
---------------
$userid = 'your_user_id';
$user = $client->get_user($userid);

$page = 1;
$per_page = 1;
$nodeid = 'your_node_id'
$allnodetrans = $user->get_all_node_trans($nodeid, $page, $per_page );
```

#### Create Transaction
```php
Nodeid and body is required. Idempotency key is set to null by default.
---------------
$userid = 'your_user_id';
$user = $client->get_user($userid);

$to = (object)[
   "type" => "ACH-US",
   "id" => 'to_node_id'
];
$amount = (object)[
   "amount" => 22.1,
   "currency" => "USD"
];
$extra = (object)[
   "ip" => "IP_address_of_user_device_while_creating_transaction"
];
$body = (object)[
   "to" => $to,
   "amount" => $amount,
   "extra" => $extra
];
$nodeid = 'your_node_id';
$idempotency_key = 'your_idempotency_key';
$trans = $user->create_trans($nodeid, $body, $idempotency_key);
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

#### Get a User Transaction
```php
Nodeid and transid are required.
---------------
$userid = 'your_user_id';
$user = $client->get_user($userid);

$nodeid = 'your_node_id';
$transid = 'your_trans_id';
$usertrans = $user->get_trans( $nodeid, $transid );
```

#### Comment on Status/Transaction
```php
Nodeid, transid and body are required .
---------------
$userid = 'your_user_id';
$user = $client->get_user($userid);

$nodeid = 'your_node_id';
$transid = 'your_trans_id';
$body = (object)[
   "comment" => "add comment"
];
$comment = $user->comment_trans( $nodeid, $transid, $body );
```
#### Delete Transaction
```php
Nodeid and transid are required.
---------------
$userid = 'your_user_id';
$user = $client->get_user($userid);

$nodeid = 'your_node_id';
$transid = 'your_trans_id';
$usertrans = $user->delete_transaction($nodeid, $transid);
```


#### Dispute Transaction
```php
Nodeid, transid and body are required .
---------------
$userid = 'your_user_id';
$user = $client->get_user($userid);

$nodeid = 'your_node_id';
$transid = 'your_trans_id';
$body = (object)[
   "dispute_reason" => "CHARGE_BACK"
];
$comment = $user->comment_trans( $nodeid, $transid, $body );
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
