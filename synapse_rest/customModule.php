<!-- This file will be deleted and was create for CF-544 -->
<!-- Run "php synapse_rest/customModule.php" to create a user on integrationy via PHP script -->
<!-- Run  "php vendor/bin/phpunit synapse_rest/test.php"  to create a user on integrationy via Test class -->
<?php
include('client.php');

$clientObj = (object) [
   'client_id' => 'client_id_QRtPbYMHNiLho603gF9uGcDWmj7Upva52IAyEfle',
   'client_secret' => 'client_secret_QCOoA2a5FyiLUtGKJu8vzX14DjNV7Ee9b0BlnSwk',
   'fingerprint' => '0347b64bb332a9d688057acb1a6b2b57',
   'ip_address' => '108.235.114.35',
   'devmode' => True,
   'logging' => True,
   'handle202' => True,
   'full_dehydrate' => False,
   'idempotency_key' => 'testData'
];

 $logins_array = array();
 $logins_array[] = (object) [
   'email' => 'mr.t@synapsefi.com',
 ];

 $legalnames_array = array();
 $legalnames_array[] = 'Synapse PHP SDK User';
 $phoneNumbers_array = array();
 $phoneNumbers_array[] = '777.111.1111';

 $body = (object)[
  'logins' => $logins_array,
  'legal_names' => $legalnames_array,
  'phone_numbers' => $phoneNumbers_array
 ];


 $client = new Client($clientObj);
 $testObj = $client->create_user($body);


 print_r($testObj);

?>