## Requirements

```php
Add a require statement at the top of your php file. Vendor folder will contain the Synapse Library
----------------------------------------------------------------------------------------------------
require_once 'vendor/synapsefi/synapse_pay_rest/synapse_rest/client.php';

```


## Initialization

```php
The parameters client_id, client_secret, fingerprint, ip_address and devmode are required. The paremeters logging and handle202 are optional and set to null by default.

(Required) Devmode: [True or False]
(Optional) logging: [True]
(Optional) handle202: [True]

Devmode: True toggles development/sandbox and False toggles production
logging: Will print the API endpoint to console if set to true
handle202: Will return an Exception object if set to true
--------------------------------------------------------------------------------------------------------------------------
$clientObj = (object) [
   'client_id' => 'your_client_id',
   'client_secret' => 'your_client_secret',
   'fingerprint' => '|your_finger_print',
   'ip_address' => 'your_ip_address',
   'devmode' => True,
   'logging' => True,
   'handle202' => True
];
client = Client($clientObj);
```

#### Get All Users on Platform

```php
All these params are optional. Set the arguments as null to exclude them.
---------------------------------------------------------------------------
$query = 'test';
$page = 1;
$per_page = 1;
$show_refresh = 'yes';
$allusers = $client->get_all_users($query, $page, $per_page, $show_refresh);
```

#### Create a User
```php
Body is required and idempotency key is optional. Idempotency key is set to null by default.
---------------------------------------------------------------------------------------------
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
---------------------------------------------------------------------------------------------
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


#### Delete Existing Documents
```php
Body is required.
---------------
$body = array (
  'documents' =>
  array (
    array (
      'id' => 'your_updated_id',
      "permission_scope" => "DELETE_DOCUMENT"
    )
  )
);
$user = $client->update_info($body);
```

#### Update User
```php
Body is required.
---------------
$login = (object) [
   'email' => 'CharlieMurphy@synapsefi.com'
];
$body = (object)[
   'update' = $login
];
$user = $client->update_info($body);
```

#### Generate UBO
```php
Entity is required and idempotency key is optional. Idempotency Key is null by default.
----------------------------------------------------------------------------------------
$entity = (object) [
   "cryptocurrency" => True,
   "gambling" => False,
   "document_id" => "2a4a5957a3a62aaac1a0dd0edcae96ea2cdee688ec6337b20745eed8869e3ac8"
];
$idempotency_key = 'your_idempotency_key';
$user = $client->create_ubo($entity, $idempotency_key);
```

#### Oauth User
```php
Body is required
-----------------
$user = $client->get_user('your_user_id');
$body = (object) [
   "refresh_token" => "refresh_ehG7YBS8ZiD0sLa6PQHMUxryovVkJzElC5gWROXq"
];
$oauthpayload = $user->ouath($body);
```

#### Select Two Factor Authentication device
```php
Body is required
-----------------
$user = $client->get_user('your_user_id');
$body = (object) [
   "refresh_token" => "refresh_ehG7YBS8ZiD0sLa6PQHMUxryovVkJzElC5gWROXq",
   "phone_number" => 'your_device'
];
$oauthpayload = $user->select_2fa_device($body);
```

#### Confirm Pin from Two Factor Authentication device
```php
Body is required
-----------------
$user = $client->get_user('your_user_id');
$body = (object) [
   "refresh_token" => "refresh_ehG7YBS8ZiD0sLa6PQHMUxryovVkJzElC5gWROXq",
   "validation_pin" => "your_pin"
];
$oauthpayload = $user->confirm_2fa_pin($body);
```


#### Retrieve All Nodes
```php
All parameters are optional. Page, per page and type are set to null by default.
--------------------------------------------------------------------------------
$page = 1;
$per_page = 1;
$type = 'SYNAPSE-US';
$allNodes = get_all_nodes($page , $per_page , $type);
```

#### Create Deposit Node
```php
Body is required and idempotency key is optional. Idempotency key is set to null by default.
--------------------------------------------------------------------------------------------
$info= (object) [
   "nickname" => "My Checking"
];
$body = (object) [
   'type' => 'DEPOSIT-US',
   'info' => $info
];

$idempotency_key = 'your_idempotency_key';
$depositnode = create_node($body , $idempotency_key);
```

#### Create Card Node
```php
Body is required and idempotency key is optional. Idempotency key is set to null by default.
--------------------------------------------------------------------------------------------
$info= (object) [
   "nickname" => "My Debit Card",
   "document_id" => "2a4a5957a3a62aaac1a0dd0edcae96ea2cdee688ec6337b20745eed8869e3ac8"
];
$body = (object) [
   'type' => 'CARD-US',
   'info' => $info
];

$idempotency_key = 'your_idempotency_key';
$user = $client->get_user('your_user_id');
$depositnode = $user->create_node($body , $idempotency_key);
```


#### Ship Debit Card
```php
Body is required and idempotency key is optional. Idempotency key is set to null by default.
--------------------------------------------------------------------------------------------
$body = (object) [
   "fee_node_id" => "5ba05e7920b3aa006482c5ad",
   "expedite" => true
];
$nodeid = 'your_node_id'
$user = $client->get_user('your_user_id');
$shipdebit = $user->ship_debit($nodeid , $body);
```

#### Reset Debit Card
```php
Nodeid is required
---------------------
$nodeid = 'your_node_id';
$user = $client->get_user('your_user_id');
$resetdebit = $user->reset_debit($nodeid);
```

#### Create ACH-US with Logins
```php

Body is required, and idempotency key is optional. Idempotency key is set to null by default
---------------------------------------------------------------------------------------------
$infoachus = (object)[
 "bank_id" => "synapse_good",
 "bank_pw" => "test1234",
 "bank_name" => "fake"
];
$body = (object) [
 "type" => "ACH-US",
 "info" => $infoachus
];

$idempotency_key = 'your_idempotency_key';
$user = $client->get_user('your_user_id');
$achusnodelogins = $user->create_node($body, $idempotency_key);
```

#### Create ACH-US with MFA
```php

Body is required, and idempotency key is optional. Idempotency key is set to null by default
---------------------------------------------------------------------------------------------
$body = (object)[
     "access_token" => "fake_cd60680b9addc013ca7fb25b2b70",
     "mfa_answer" => "test_answer"
];

$idempotency_key = 'your_idempotency_key';
$user = $client->get_user('your_user_id');
$achusnodemfa = $user->submit_mfa($body, $idempotency_key);
```

#### Create ACH-US with AC/RT
```php

Body is required, and idempotency key is optional. Idempotency key is set to null by default
---------------------------------------------------------------------------------------------
$infoachus = (object)[
 "nickname" => "Fake Account",
 "account_num" => "1232225674134",
 "routing_num" => "051000017",
 "type" => "PERSONAL",
 "class" => "CHECKING"
];
$body = (object) [
 "type" => "ACH-US",
 "info" => $infoachus
];

$idempotency_key = 'your_idempotency_key';
$user = $client->get_user('your_user_id');
$achusnode = $user->create_node($body, $idempotency_key);
```

#### Verify Micro Deposit with AC/RT
```php
Nodeid and body are both required, and idempotency key is optional. Idempotency key is set to null by default
--------------------------------------------------------------------------------------------------------------
$body = (object) [
 "micro" => [0.1,0.1]
];
$user = $client->get_user('your_user_id');
$nodeid = 'your_node_id';
$verifymicro = $user->verify_micro($nodeid, $body);
```

#### Reinitiate Micro Deposits
```php
Nodeid is required.
---------------------
$user = $client->get_user('your_user_id');
$nodeid = 'your_node_id';
$reinit = $user->reinit_micro($nodeid);
```

####  Get Node
```php
Nodeid is required, full dehydrate and force refresh are optional. Full dehydrate and force refresh are set to null as default
------------------------------------------------------------------------------------------------------------------------------
$user = $client->get_user('your_user_id');
$nodeid = 'your_node_id';
$full_dehydrate=null;
$force_refresh = null;
$node = $user->get_node($nodeid, $full_dehydrate, $force_refresh);
```

####  Update Node
```php
Nodeid and body are required
-----------------------------
$user = $client->get_user('your_user_id');

$nodeid = 'your_node_id';
$body = (object)[
   "supp_id" => "new_supp_id_1234"
];
$updatednode = $user->update_node($nodeid, $body);
```

####  Delete Node
```php
Nodeid is required
-------------------
$user = $client->get_user('your_user_id');

$nodeid = 'your_node_id';
$deletenode = $user->update_node($nodeid);
```

####  Generate Apple Pay
```php
Nodeid and body are required
-----------------------------
$user = $client->get_user('your_user_id');
$body = (object)[
   "certificate" => "your applepay cert",
   "nonce" => "9c02xxx2",
   "nonce_signature" => "4082f883ae62d0700c283e225ee9d286713ef74"
];
$nodeid = 'your_node_id';
$applepay = $user->generate_apple_pay($nodeid, $body);
```

####  Get Subnets
```php
Nodeid is required, page and per page are optional. Page and per page are set to null as default
-------------------------------------------------------------------------------------------------
$user = $client->get_user('your_user_id');

$nodeid = 'your_node_id';
$page=null;
$per_page=null;
$subnets = $user->get_subnets($nodeid, $page, $per_page);
```

####  Get Subnet
```php
Nodeid and subnetid are required
---------------------------------
$user = $client->get_user('your_user_id');

$nodeid = 'your_node_id';
$subnetid = 'your_subnet_id';
$subnet = $user->get_subnet($nodeid, $subnetid);
```


####  Create Subnet
```php
Nodeid and body are required, idempotency key is optional. Idempotency key is set to null by default.
-----------------------------------------------------------------------------------------------------
$user = $client->get_user('your_user_id');

$nodeid = 'your_node_id';
$body = (object)[
   "nickname" => "Test AC/RT"
];
$idempotency_key = 'your_idempotency_key';
$newsubnet = $user->create_subnet($nodeid, $body, $idempotency_key);
```

#### Get All Platform/Client Transactions
```php
No arguments are required. Set $page and $per_page as null to exclude it.
------------------------------------------------------------------------
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
--------------------------------------------------------------------
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
------------------------------------------------------------------------
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


#### Get a User Transaction
```php
Nodeid and transid are required.
--------------------------------
$userid = 'your_user_id';
$user = $client->get_user($userid);

$nodeid = 'your_node_id';
$transid = 'your_trans_id';
$usertrans = $user->get_trans( $nodeid, $transid );
```

#### Comment on Status/Transaction
```php
Nodeid, transid and body are required
----------------------------------------
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
Nodeid and transid are required
--------------------------------
$userid = 'your_user_id';
$user = $client->get_user($userid);

$nodeid = 'your_node_id';
$transid = 'your_trans_id';
$usertrans = $user->delete_transaction($nodeid, $transid);
```


#### Dispute Transaction
```php
Nodeid, transid and body are required
--------------------------------------
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
No arguments required
---------------------
$allInstitutions = $client->get_all_institutions();

```

##### Retrieve All Subscriptions
```php
Page and per page are optional. Both are set to null by default
---------------------------------------------------------------
$page = 1;
$per_page = 1;
$allsubs = $client->get_all_subscriptions($page, $per_page);
```


##### Retrieve a Subscription
```php
Subscriptionid is required.
----------------------------
 $subscriptionid = 'your_subscription_id';
 $sub = $client->get_subscription(  $subscriptionid );

```

##### Create Subscription
```php
Body is required, idempotency key is optional. Idempotency key is set to null by default.
------------------------------------------------------------------------------------------

  $body= (object) [
     scope" => [
       "USERS|POST",
       "USER|PATCH",
       "NODES|POST",
       "NODE|PATCH",
       "TRANS|POST",
       "TRAN|PATCH"
     ],
      'url' => 'https://requestb.in/zp216zzp'
  ];

  $idempotency_key = 'your_idempotency_key';
  $newSubscription = $client->create_subscription( $body, $idempotency_key );

```

##### Update Subscription
```php  
Body and subscriptionid are required.
-------------------------------------
  $body= (object) [
     'scope' => $scope_arr,
     'is_active' => false,
     'url' => 'https://requestb.in/zp216zzp'
  ];

  $subscriptionid = 'your_subscription_id';
  $updateSubscriptionObj = $client->update_subscription( $subscriptionid, $body );

```

##### Get Statement by User
```php  
Page and per page are optional. Both are set to null by default.
----------------------------------------------------------------
 $user = $client->get_user('your_user_id');
 $page=null;
 $per_page=null;
 $userstatements = $user->get_user_statements($page=null, $per_page=null);

```

##### Get Node Statements
```php  
Page and per page are optional. Both are set to null by default.
----------------------------------------------------------------
 $user = $client->get_user('your_user_id');
 $page=null;
 $per_page=null;
 $nodeid = 'your_node_id';

 $nodestatements = $user->get_node_statements($nodeid, $page, $per_page);
```

##### Get Public Key
```php  
Scope is optional. Scope is set to null by default.
---------------------------------------------------
 $scope = 'OAUTH|POST,USERS|POST,USERS|GET,USER|GET,USER|PATCH,SUBSCRIPTIONS|GET,SUBSCRIPTIONS|POST,SUBSCRIPTION|GET,SUBSCRIPTION|PATCH,CLIENT|REPORTS,CLIENT|CONTROLS';

 $pkey = $client->issue_public_key($scope);
```

##### Get Local ATM's
```php  
All arguments are optional and set to null by default.
-----------------------------------------------------

 $zip = 94114;
 $lat = null;
 $lon = null;
 $radius = 5;
 $page = 1;
 $per_page = 1;

 $atms = $client->locate_atms($zip , $lat , $lon , $radius , $page , $per_page );
```

##### Get Crypto Quotes
```php  
No arguments
-------------

$quotes = $client->get_crypto_quotes();
```

##### Get Crypto Market Data
```php  
Limit and currency are required
--------------------------------
$limit = 5;
$currency = "BTC";

$marketdata = $client->get_crypto_market_data($limit, $currency);
```
