## Requirements

```php
Add an include statement at the top of your php file that points to client.php
----------------------------------------------------------------------------------------------------
include 'client.php';
```

## Initialization

Visit for product documentation: [Synapse Documentation](https://docs.synapsefi.com/)

```php
/**
 * @param string $client_id
 * @param string $client_secret
 * @param string $fingerprint
 * @param string $ip_address
 * @param bool $devmode
 * @param bool|null $logging
 * @param bool|null $handle202
 * 
 * @see https://docs.synapsefi.com/
 *
 * Initialize a new Client instance with the specified client information.
 * The parameters client_id, client_secret, fingerprint, ip_address and devmode are required.
 * The parameters logging and handle202 are optional and set to null by default.
 *
 * Devmode: True toggles development/sandbox and False toggles production.
 * logging: Will print the API endpoint to console if set to true.
 * handle202: Will return an Exception object if set to true.
 */
$clientObj = (object) [
   'client_id' => 'your_client_id',
   'client_secret' => 'your_client_secret',
   'fingerprint' => 'your_finger_print',
   'ip_address' => 'your_ip_address',
   'devmode' => True,
   'logging' => True,
   'handle202' => True
];

$client = new Client($clientObj);

```

#### Get All Users on Platform

```php
/**
 * @param string $query
 * @param int $page
 * @param int $per_page
 * @param string $show_refresh
 * @return array
 *
 * Retrieve a list of users matching the specified filter criteria. All parameters are optional.
 * Set any arguments to null to exclude them from the filter.
 */
$allusers = $client->get_all_users($query, $page, $per_page, $show_refresh);
```

#### Create a User

```php
/**
 * @param object $body
 * @param string|null $idempotency_key
 * @return mixed
 *
 * Create a new user with the specified information.
 * The parameter $body is required, and $idempotency_key is optional and set to null by default.
 */
$body = (object) [
  'login_obj' => $logins_obj
  'legal_names' => $legal_names,
  'phone_number' => $phone_number
];

$idempotency_key = 'your_idempotency_key';
$newuser = $client->create_user($body, $idempotency_key);
```

#### Get a Single User on Platform

```php
/**
 * @param string $userid
 * @param string|null $newFingerPrint
 * @param string|null $full_dehydrate
 * @return mixed
 *
 * Retrieve a user with the specified id.
 * The parameter $userid is required, and $newFingerPrint and $full_dehydrate are optional and set to null by default.
 */
$newFingerPrint=null;
$full_dehydrate = 'yes';
$user = $client->get_user('your_user_id', $newFingerPrint ,$full_dehydrate);
```

#### Add New Documents

```php
/**
 * @param array $body
 * @return mixed
 *
 * Update user information with the specified data. The parameter $body is required.
 */
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
/**
 * Update user information
 * 
 * @param array $body The body of the request, containing the user information to update
 * 
 * @return object $user The updated user object
 */
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
/**
 * Update user information
 * 
 * @param array $body The body of the request, containing the user information to update
 * 
 * @return object $user The updated user object
 */
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
/**
 * Update user information
 * 
 * @param object $body The body of the request, containing the user information to update
 * 
 * @return object $user The updated user object
 */
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
/**
 * Create UBO (Ultimate Beneficial Owner)
 * 
 * @param object $entity The UBO entity to create
 * @param string $idempotency_key [optional] Idempotency key to prevent duplicate UBO creations
 * 
 * @return object $user The created UBO object
 */
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
/**
 * Refresh OAuth access token
 * 
 * @param object $body The body of the request, containing the refresh token
 * 
 * @return object $oauthpayload The OAuth payload, including the new access token
 */
$user = $client->get_user('your_user_id');
$body = (object) [
   "refresh_token" => "refresh_ehG7YBS8ZiD0sLa6PQHMUxryovVkJzElC5gWROXq"
];
$oauthpayload = $user->oauth($body);

```

#### Select Two Factor Authentication device

```php
/**
 * Select 2FA device
 * 
 * @param object $body The body of the request, containing the refresh token and the phone number of the device to use for 2FA
 * 
 * @return object $oauthpayload The OAuth payload, including the new access token
 */
$user = $client->get_user('your_user_id');
$body = (object) [
   "refresh_token" => "refresh_ehG7YBS8ZiD0sLa6PQHMUxryovVkJzElC5gWROXq",
   "phone_number" => 'your_device'
];
$oauthpayload = $user->select_2fa_device($body);

```

#### Confirm Pin from Two Factor Authentication device

```php
/**
 * Confirm 2FA PIN
 * 
 * @param object $body The body of the request, containing the refresh token and the 2FA PIN to confirm
 * 
 * @return object $oauthpayload The OAuth payload, including the new access token
 */
$user = $client->get_user('your_user_id');
$body = (object) [
   "refresh_token" => "refresh_ehG7YBS8ZiD0sLa6PQHMUxryovVkJzElC5gWROXq",
   "validation_pin" => "your_pin"
];
$oauthpayload = $user->confirm_2fa_pin($body);
```

#### Retrieve All Nodes

```php
/**
 * Get all nodes
 * 
 * @param int $page [optional] The page number to retrieve
 * @param int $per_page [optional] The number of nodes per page
 * @param string $type [optional] The type of node to retrieve
 * 
 * @return array $allNodes An array of all nodes matching the specified criteria
 */
$page = 1;
$per_page = 1;
$type = 'SYNAPSE-US';
$allNodes = get_all_nodes($page , $per_page , $type);
```

#### Create Deposit Node

```php
/**
 * Create node
 * 
 * @param object $body The body of the request, containing the node information
 * @param string $idempotency_key [optional] Idempotency key to prevent duplicate node creations
 * 
 * @return object $depositnode The created node object
 */
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
/**
 * -- Deprecated --
 * 
 * Create node for a specific user
 * 
 * @param object $body The body of the request, containing the node information
 * @param string $idempotency_key [optional] Idempotency key to prevent duplicate node creations
 * 
 * @return object $cardnode The created node object
 */
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
$cardnode = $user->create_node($body , $idempotency_key);

```

#### Ship Debit Card

```php
/**
 * Ship debit card
 * 
 * @param string $nodeid The ID of the debit card node to ship
 * @param object $body The body of the request, containing the fee node ID and expedite flag
 * 
 * @return object $shipdebit The response object for the ship debit request
 */
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
/**
 * Reset debit card
 * 
 * @param string $nodeid The ID of the debit card node to reset
 * 
 * @return object $resetdebit The response object for the reset debit request
 */
$nodeid = 'your_node_id';
$user = $client->get_user('your_user_id');
$resetdebit = $user->reset_debit($nodeid);

```

#### Create ACH-US with Logins

```php
/**
 * Create ACH-US node for a specific user
 * 
 * @param object $body The body of the request, containing the ACH-US node information
 * @param string $idempotency_key [optional] Idempotency key to prevent duplicate node creations
 * 
 * @return object $achusnodelogins The created ACH-US node object
 */
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
/**
 * Submit MFA response
 * 
 * @param object $body The body of the request, containing the access token and MFA answer
 * @param string $idempotency_key [optional] Idempotency key to prevent duplicate submissions
 * 
 * @return object $achusnodemfa The response object for the MFA submission
 */
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

/**
 * Create a new ACH-US node for a user
 *
 * @param object $body The request body containing the information for the ACH-US node
 * @param string|null $idempotency_key (optional) The idempotency key to prevent duplicate node creations
 *
 * @return object The newly created ACH-US node
 */
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
/**
 * Verify a node using micro deposits
 *
 * @param string $nodeid The ID of the node to verify
 * @param object $body The request body containing the micro deposit amounts
 * @param string|null $idempotency_key (optional) The idempotency key to use for the request
 *
 * @return object The verification response
 */
$body = (object) [
    "micro" => [0.1,0.1]
];
$user = $client->get_user('your_user_id');
$nodeid = 'your_node_id';
$verifymicro = $user->verify_micro($nodeid, $body);

```

#### Reinitiate Micro Deposits

```php
/**
 * Reinitiate the micro deposit verification process for a node
 *
 * @param string $nodeid The ID of the node to reinitiate verification for
 *
 * @return object The verification response
 */
$user = $client->get_user('your_user_id');
$nodeid = 'your_node_id';
$reinit = $user->reinit_micro($nodeid);

```

#### Get Node

```php
/**
 * Get a node for a user
 *
 * This function retrieves a node object for a given user and node ID. The full_dehydrate and
 * force_refresh parameters are optional and can be set to null by default.
 *
 * @param string $nodeid The ID of the node to get
 * @param string|null $full_dehydrate (optional) Whether to fully dehydrate the node. Dehydrating
 * a node removes sensitive information such as account and routing numbers.
 * @param bool|null $force_refresh (optional) Whether to force a refresh of the node's data from
 * the bank. If set to false, the cached data will be used if available.
 *
 * @return object The node
 */
$user = $client->get_user('your_user_id');
$nodeid = 'your_node_id';
$full_dehydrate=null;
$force_refresh = null;
$node = $user->get_node($nodeid, $full_dehydrate, $force_refresh);

```

#### Update Node

```php
/**
 * Update a node for a user
 *
 * This function updates the specified node with the provided information.
 *
 * @param string $nodeid The ID of the node to update
 * @param object $body The request body containing the updated node information
 *
 * @return object The updated node
 */
$user = $client->get_user('your_user_id');

$nodeid = 'your_node_id';
$body = (object)[
   "supp_id" => "new_supp_id_1234"
];
$updatednode = $user->update_node($nodeid, $body);

```

#### Delete Node

```php
/**
 * Delete a node for a user
 *
 * This function deletes the specified node.
 *
 * @param string $nodeid The ID of the node to delete
 *
 * @return object The deleted node
 */
$user = $client->get_user('your_user_id');

$nodeid = 'your_node_id';
$deletenode = $user->delete_node($nodeid);
```

#### Generate Apple Pay

```php
/**
 * Generate an Apple Pay token for a node
 *
 * This function generates an Apple Pay token for the specified node using the provided certificate
 * and nonce information.
 *
 * @param string $nodeid The ID of the node to generate the Apple Pay token for
 * @param object $body The request body containing the certificate, nonce, and nonce signature
 *
 * @return object The generated Apple Pay token
 */
$user = $client->get_user('your_user_id');
$body = (object)[
   "certificate" => "your applepay cert",
   "nonce" => "9c02xxx2",
   "nonce_signature" => "4082f883ae62d0700c283e225ee9d286713ef74"
];
$nodeid = 'your_node_id';
$applepay = $user->generate_apple_pay($nodeid, $body);

```

#### Get Subnets

```php
/**
 * Get the subnets for the specified node.
 *
 * @param string $nodeid The ID of the node to retrieve subnets for.
 * @param int|null $page The page number to retrieve.
 * @param int|null $per_page The number of subnets to retrieve per page.
 * @return array An array of subnet objects.
 */
$user = $client->get_user('your_user_id');
$nodeid = 'your_node_id';
$page=null;
$per_page=null;
$subnets = $user->get_subnets($nodeid, $page, $per_page);
```

#### Get Subnet

```php
/**
 * Get the subnet with the specified ID for the specified node.
 *
 * @param string $nodeid The ID of the node that the subnet belongs to.
 * @param string $subnetid The ID of the subnet to retrieve.
 * @return object The subnet object.
 */
$user = $client->get_user('your_user_id');
$nodeid = 'your_node_id';
$subnetid = 'your_subnet_id';
$subnet = $user->get_subnet($nodeid, $subnetid);
```

#### Create Subnet

```php
/**
 * Create a new subnet for the specified node.
 *
 * @param string $nodeid The ID of the node to create the subnet for.
 * @param object $body The body of the request to create the subnet.
 * @param string|null $idempotency_key An optional idempotency key to prevent accidental creation of multiple subnets.
 * @return object The newly created subnet object.
 */
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
/**
 * Get all platform transactions.
 *
 * @return array An array of platform transaction objects.
 */
$allplatformtrans = $client->get_all_platform_transactions();
```

#### Get All User Transactions

```php
/**
 * Get all transactions for the user.
 *
 * @param int|null $page The page number to retrieve.
 * @param int|null $per_page The number of transactions to retrieve per page.
 * @return array An array of transaction objects.
 */
$user = $client->get_user('your_user_id');
$page = 1;
$per_page = 1;
$allusertrans = $user->get_all_transactions( $page, $per_page );
```

#### Get All Node Transactions

```php
/**
 * Get all transactions for the specified node.
 *
 * @param string $nodeid The ID of the node to retrieve transactions for.
 * @param int|null $page The page number to retrieve.
 * @param int|null $per_page The number of transactions to retrieve per page.
 * @return array An array of transaction objects.
 */
$user = $client->get_user('your_user_id');
$page = 1;
$per_page = 1;
$nodeid = 'your_node_id';
$allnodetrans = $user->get_all_node_trans($nodeid, $page, $per_page );

```

#### Create Transaction

```php
/**
 * Create a new transaction.
 *
 * @param string $nodeid The ID of the node to create the transaction for.
 * @param object $body The body of the request to create the transaction.
 * @param string|null $idempotency_key An optional idempotency key to prevent accidental creation of multiple transactions.
 * @return object The newly created transaction object.
 */
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

$user = $client->get_user('your_user_id');
$nodeid = 'your_node_id';
$body = (object)[
   "to" => $to,
   "amount" => $amount,
   "extra" => $extra
];
$idempotency_key = 'your_idempotency_key';
$trans = $user->create_trans($nodeid, $body, $idempotency_key);

```

#### Get a User Transaction

```php
/**
 * Get the transaction with the specified ID for the specified node.
 *
 * @param string $nodeid The ID of the node that the transaction belongs to.
 * @param string $transid The ID of the transaction to retrieve.
 * @return object The transaction object.
 */
$user = $client->get_user('your_user_id');
$nodeid = 'your_node_id';
$transid = 'your_trans_id';
$usertrans = $user->get_trans( $nodeid, $transid );
```

#### Comment on Status/Transaction

```php
/**
 * Add a comment to the specified transaction.
 *
 * @param string $nodeid The ID of the node that the transaction belongs to.
 * @param string $transid The ID of the transaction to add the comment to.
 * @param object $body The body of the request to add the comment.
 * @return object The updated transaction object.
 */
$user = $client->get_user( 'your_user_id');
$nodeid = 'your_node_id';
$transid = 'your_trans_id';
$body = (object)[
   "comment" => "add comment"
];
$comment = $user->comment_trans( $nodeid, $transid, $body );

```

#### Delete Transaction

```php
/**
 * Delete the transaction with the specified ID for the specified node.
 *
 * @param string $nodeid The ID of the node that the transaction belongs to.
 * @param string $transid The ID of the transaction to delete.
 * @return object The deleted transaction object.
 */
$user = $client->get_user( 'your_user_id');
$nodeid = 'your_node_id';
$transid = 'your_trans_id';
$usertrans = $user->delete_transaction($nodeid, $transid);

```

#### Dispute Transaction

```php
/**
 * Dispute the transaction with the specified ID for the specified node.
 *
 * @param string $node_id The ID of the node that the transaction belongs to.
 * @param string $trans_id The ID of the transaction to dispute.
 * @param array $body The request body for the dispute transaction request.
 * @return object The disputed transaction object.
 */
$node_id = '594e606212e17a002f2e3251';
$trans_id = '594e72124599e8002fe62e4f';
$dispute_reason = 'Chargeback...';
$dispute_meta = [
	"type_of_merchandise_or_service" => "groceries",
	"merchant_contacted" => true,
	"contact_method" => "phone",
	"contact_date" => 1563474864000
];
$certification_date = 1579308186000;
$dispute_attachments = [
	"data:image/gif;base64,SUQs=="
];
$body = [
  "dispute_reason" => $dispute_reason,
 "dispute_meta" => $dispute_meta,
 "certification_date" => $certification_date,
 "dispute_attachments" => $dispute_attachments
];
$disputed_trans = $user->dispute_trans($node_id, $trans_id,  $body);
```

##### Retrieve Institutions

```php
/**
 * Retrieve a list of all institutions.
 *
 * @return array An array of institution objects.
 */
$allInstitutions = $client->get_all_institutions();
```

##### Retrieve All Subscriptions

```php
/**
 * Retrieve a list of all subscriptions.
 *
 * @param int|null $page The page number to retrieve. Default is `null`.
 * @param int|null $per_page The number of subscriptions per page. Default is `null`.
 * @return array An array of subscription objects.
 */
$page = 1;
$per_page = 1;
$allsubs = $client->get_all_subscriptions($page, $per_page);
```

##### Retrieve a Subscription

```php
/**
 * Retrieve a subscription with the specified ID.
 *
 * @param string $subscriptionid The ID of the subscription to retrieve.
 * @return object The subscription object.
 */
$subscriptionid = 'your_subscription_id';
$sub = $client->get_subscription(  $subscriptionid );
```

##### Create Subscription

```php
/**
 * Create a new subscription.
 *
 * @param object $body The request body for the create subscription request.
 * @param string|null $idempotency_key An idempotency key to use for the request. Default is `null`.
 * @return object The created subscription object.
 */
$body = (object) [
     "scope" => [
       "USERS|POST",
       "USER|PATCH",
       "NODES|POST",
       "NODE|PATCH",
       "TRANS|POST",
       "TRAN|PATCH"
     ],
     "url" => "https://requestb.in/zp216zzp"
  ];
$idempotency_key = 'your_idempotency_key';
$newSubscription = $client->create_subscription( $body, $idempotency_key );

```

##### Update Subscription

```php
/**
 * Update an existing subscription with the specified ID.
 *
 * @param string $subscriptionid The ID of the subscription to update.
 * @param object $body The request body for the update subscription request.
 * @return object The updated subscription object.
 */
$body = (object) [
     "scope" => $scope_arr,
     "is_active" => false,
     "url" => "https://requestb.in/zp216zzp"
  ];
$subscriptionid = 'your_subscription_id';
$updateSubscriptionObj = $client->update_subscription( $subscriptionid, $body );

```

##### Get Statement by User

```php
/**
 * Retrieve a list of user statements.
 *
 * @param int|null $page The page number to retrieve. Default is `null`.
 * @param int|null $per_page The number of statements per page. Default is `null`.
 * @return array An array of statement objects.
 */
$user = $client->get_user('your_user_id');
$page = null;
$per_page = null;
$userstatements = $user->get_user_statements($page, $per_page);
```

##### Get Node Statements

```php
/**
 * Retrieve a list of node statements for the specified node.
 *
 * @param string $nodeid The ID of the node to retrieve statements for.
 * @param int|null $page The page number to retrieve. Default is `null`.
 * @param int|null $per_page The number of statements per page. Default is `null`.
 * @return array An array of statement objects.
 */
$user = $client->get_user('your_user_id');
$page = null;
$per_page = null;
$nodeid = 'your_node_id';
$nodestatements = $user->get_node_statements($nodeid, $page, $per_page);

```

##### Get Public Key

```php
/**
 * Issue a public key for the specified user.
 *
 * @param string|null $scope A comma-separated list of authorized scopes for the key. Default is `null`.
 * @param string|null $userid The ID of the user to issue the key for. Default is `null`.
 * @return object The public key object.
 */
$scope = 'OAUTH|POST,USERS|POST,USERS|GET,USER|GET,USER|PATCH,SUBSCRIPTIONS|GET,SUBSCRIPTIONS|POST,SUBSCRIPTION|GET,SUBSCRIPTION|PATCH,CLIENT|REPORTS,CLIENT|CONTROLS';
$userid = 'your_user_id';
$pkey = $client->issue_public_key($scope, $userid);

```

##### Get Local ATM's

```php
/**
 * Retrieve a list of ATMs based on the given search criteria.
 *
 * @param int|null $zip The zip code to search within. Default is `null`.
 * @param float|null $lat The latitude to search within. Default is `null`.
 * @param float|null $lon The longitude to search within. Default is `null`.
 * @param int|null $radius The radius (in miles) to search within. Default is `null`.
 * @param int|null $page The page number of the search results. Default is `null`.
 * @param int|null $per_page The number of search results per page. Default is `null`.
 * @return array An array of ATM objects.
 */
$zip = 94114;
$lat = null;
$lon = null;
$radius = 5;
$page = 1;
$per_page = 1;
$atms = $client->locate_atms($zip, $lat, $lon, $radius, $page, $per_page);

```

##### Get Crypto Quotes

```php
/**
 * Retrieve the current quotes for various cryptocurrencies.
 *
 * @return array An array of cryptocurrency quote objects.
 */
$quotes = $client->get_crypto_quotes();
```

##### Get Crypto Market Data

```php
/**
 * Retrieve market data for a given cryptocurrency.
 *
 * @param int $limit The number of records to retrieve.
 * @param string $currency The currency to retrieve market data for.
 *
 * @return array An array of market data objects.
 */
$limit = 5;
$currency = "BTC";

$marketdata = $client->get_crypto_market_data($limit, $currency);
```
