Initialization 

from synapse_pay_rest import Client

$clientObj = (object) [
  'XSPGATEWAY' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
  'XSPUSERIP' => '127.0.0.1',
  'XSPUSER' => '|123456'
];
client = Client($clientObj);


--CREATE USER--
$baseDoc = (object) [
  'login_obj' => $logins_obj
  'legal_names' => '$legal_names',
  'phone_number' => '$phone_number'
];
$newUser = $client->createUser($baseDoc);


--GET USER--
$getUser = $client->getUser('5bef6f1cb68b62009a5e0bb6');


--GET ALL USERS--
No spaces in 'query' parameter
---------------
$options = array(
  "query" => 'BillGates',
  "page" => 1,
  "per_page" => 1,
  "show_refresh_tokens" => yes
)
$getUser = $client->getAllUsers([options]);


--GET ALL CLIENT TRANSACTIONS--
$options = array(
  "page" => 1,
  "per_page" => 1
)
$getUser = $client->getAllClientTransactions([options]);



