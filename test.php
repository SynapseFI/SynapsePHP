<?php
include 'client.php';
include 'Subscription.php';
use \Mockery as m;
use PHPUnit\Framework\TestCase;
//require_once ('PHPUnit/Framework/TestCase.php');



Class ClientTest extends TestCase
{

public function testUpdateNode(){
  echo('yppppppp');
  $clientObj = (object) [
    'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
    'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
    'fingerprint' => '|123456',
    'ip_address' => '127.0.0.1',
    'full_dehydrate' => 'True'
  ];
  $client = new Client($clientObj);
  $user = $client->$getUser('5c0199fe3c4e280a7d7c2a31');
  $updateBody = (object) [
    "supp_id"=>"new_supp_id_1234"
  ];
  $testObj = $user->updateNode('5c0af7541cfe2300a0fe477b', $updateBody);
  $this->assertEquals(True, is_object($testObj));



  $updateBody = (object) [
  ];
  $testObj = $user->updateNode('5c0af7541cfe2300a0fe477b', $updateBody);
  $this->assertEquals("SynapseException", get_class($testObj));

}

public function testCreateNode(){
  $clientObj = (object) [
    'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
    'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
    'fingerprint' => '|123456',
    'ip_address' => '127.0.0.1',
    'full_dehydrate' => 'True'
  ];
  $client = new Client($clientObj);
  $user = $client->$getUser('5c0199fe3c4e280a7d7c2a31');
  $infoachus = (object)[
    "bank_id" => "synapse_good",
    "bank_pw" => "test1234",
    "bank_name" => "fake"
  ];
  $ach = (object) [
    "type" => "ACH-US",
    "info" => $infoachus
  ];
  $testObj = $user->createNode($ach);
  $this->assertEquals(True, is_string($testObj->access_token);
  $this->assertEquals(True, is_string($testObj->message);
  $this->assertEquals(True, is_string($testObj->type);

  $achfail = (object) [
  ];
  $testObj = $user->createNode($achfail);
  $this->assertEquals("SynapseException", get_class($testObj));

}


public function testCreateNodeMFA(){
  $clientObj = (object) [
    'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
    'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
    'fingerprint' => '|123456',
    'ip_address' => '127.0.0.1',
    'full_dehydrate' => 'True'
  ];
  $client = new Client($clientObj);
  $user = $client->$getUser('5c0199fe3c4e280a7d7c2a31');
  $mfa = (object) [
    "access_token" => "fake_cd60680b9addc013ca7fb25b2b70",
    "mfa_answer"=>"test_answer"
  ];
  $testObj = $user->createNodeMFA($mfa);
  if($testObj->http_code == '202'){
  $this->assertEquals(True, is_string($testObj->$mfa->access_token);
  $this->assertEquals(True, is_string($testObj->$mfa->message);
  }
  if($testObj->http_code == '200'){
  $this->assertEquals(True, is_object($testObj);
  }

  $achfail = (object) [
  ];
  $testObj = $user->createNode($achfail);
  $this->assertEquals("SynapseException", get_class($testObj));

}


public function testResetDebitCard(){
  $clientObj = (object) [
    'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
    'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
    'fingerprint' => '|123456',
    'ip_address' => '127.0.0.1',
    'full_dehydrate' => 'True'
  ];
  $client = new Client($clientObj);
  $user = $client->$getUser('5c0199fe3c4e280a7d7c2a31');
  $reset = (object) [];
  $testObj = $user->resetDebitCard($reset, '5c0abc754f98b000bc81c0ca');
  $this->assertEquals(True, is_object($testObj));

  $returnObj = (object) [
    //'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
    'XSPUSERIP' => '127.0.0.1',
    'XSPUSER' => '|123456',
    'id' => '5bfc547cbaabfc00b46ffd00',
    'payload' => $user->payload,
    'oauth' => $user->oauth,
    'ContentType' => 'application/json'
    'fingerprint' = '|123456';

  ];

  $newuser = new User($returnObj);
  $testObj = $newuser->resetDebitCard($reset, '5c0abc754f98b000bc81c0ca');
  $this->assertEquals("SynapseException", get_class($testObj));
}


public function testGenerateApplePay(){
  $clientObj = (object) [
    'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
    'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
    'fingerprint' => '|123456',
    'ip_address' => '127.0.0.1',
    'full_dehydrate' => 'True'
  ];
  $client = new Client($clientObj);
  $user = $client->$getUser('5be4e2b16f467000bb16e9c7');
  $body = (object)[
    "certificate" => "your applepay cert",
    "nonce" => "9c02xxx2",
    "nonce_signature" => "4082f883ae62d0700c283e225ee9d286713ef74"
  ];
  $result = $user->generate_apple_pay('5c0abc754f98b000bc81c0ca', $body);
  $this->assertEquals(True, is_string($result->data));
  $this->assertEquals(True, is_string($result->public_key));

  $body = (object)[
  ];
  $result = $user->generate_apple_pay('5c0abc754f98b000bc81c0ca', $body);
  $this->assertEquals("SynapseException", get_class($result));


}




public function testGetUserHTTP()
{
//raise a 404 error incorrect userid
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '|123456',
//   'ip_address' => '127.0.0.1',
//   'full_dehydrate' => 'True'
// ];
// $client = new Client($clientObj);
// $testObj = $client->getUserHTTP('5bfc547cbaabfc00b46ffd0');
// $this->assertEquals("SynapseException", get_class($testObj));
}

public function testGetAllPlatformNodes(){
  //http status code 200
  // $clientObj = (object) [
  // 'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
  // 'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
  // 'fingerprint' => '|123456',
  // 'ip_address' => '127.0.0.1'
  //  ];
  // $client = new Client($clientObj);
  // $nodes = $client->getAllPlatformNodes();
  //
  // $this->assertEquals(True, is_array($nodes->list_of_nodes));
  // $this->assertEquals(True, is_int($nodes->nodes_count));
  // $this->assertEquals(True, is_int($nodes->limit));
  // $this->assertEquals(True, is_int($nodes->page));
  // $this->assertEquals(True, is_int($nodes->page_count));

  //trigger 400 ommit client secret
  // $clientObj = (object) [
  // //'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
  // 'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
  // 'fingerprint' => '|123456',
  // 'ip_address' => '127.0.0.1'
  //  ];
  // $client = new Client($clientObj);
  // $nodes = $client->getAllPlatformNodes();
  // $this->assertEquals("SynapseException", get_class($nodes) );
}


public function testGetAllSubscriptions()
{

  //http status code 200
  // $clientObj = (object) [
  // 'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
  // 'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
  // 'fingerprint' => '|123456',
  // 'ip_address' => '127.0.0.1'
  //  ];
  // $client = new Client($clientObj);
  // $subs = $client->getAllSubscriptions();
  //
  // $this->assertEquals(True, is_array($subs->list_of_subs));
  // $this->assertEquals(True, is_int($subs->subscriptions_count));
  // $this->assertEquals(True, is_int($subs->limit));
  // $this->assertEquals(True, is_int($subs->page));
  // $this->assertEquals(True, is_int($subs->page_count));

  //trigger 400 ommit client secret
  // $clientObj = (object) [
  // //'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
  // 'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
  // 'fingerprint' => '|123456',
  // 'ip_address' => '127.0.0.1'
  //  ];
  // $client = new Client($clientObj);
  // $subs = $client->getAllSubscriptions();
  // $this->assertEquals("SynapseException", get_class($subs) );

}

public function testGetAllPlatformTransactions()
  {
     //http status code 200
     // $clientObj = (object) [
     // 'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
     // 'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
     // 'fingerprint' => '|123456',
     // 'ip_address' => '127.0.0.1'
     //  ];
     // $client = new Client($clientObj);
     // $trans = $client->getAllPlatformTransactions();
     //
     // $this->assertEquals(True, is_array($trans->list_of_trans));
     // $this->assertEquals(True, is_int($trans->trans_count));
     // $this->assertEquals(True, is_int($trans->limit));
     // $this->assertEquals(True, is_int($trans->page));
     // $this->assertEquals(True, is_int($trans->page_count));

     //trigger a 400 error by ommitting the client secret
     // $clientObj = (object) [
     //   // 'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
     // 'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
     // 'fingerprint' => '|123456',
     // 'ip_address' => '127.0.0.1'
     //  ];
     // $client = new Client($clientObj);
     // $trans = $client->getAllPlatformTransactions();
     // $this->assertEquals("SynapseException", get_class($trans) );
  }


public function testGetAllUsers()
{
   //http status code 200
   // $clientObj = (object) [
   // 'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
   // 'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
   // 'fingerprint' => '|123456',
   // 'ip_address' => '127.0.0.1'
   //  ];
   // $client = new Client($clientObj);
   // $users = $client->getAllUsers();
   //
   //var_dump("users ", $users);
   // //var_dump("users count ", $users->$users_count);
   // $this->assertEquals(True, is_int($users->users_count));
   // $this->assertEquals(True, is_array($users->list_of_users));
   // $this->assertEquals(True, is_int($users->limit));
   // $this->assertEquals(True, is_int($users->page));
   // $this->assertEquals(True, is_int($users->page_count));

   //trigger a 400 error by ommitting the client secret
   // $clientObj = (object) [
   // //'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
   // 'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
   // 'fingerprint' => '|123456',
   // 'ip_address' => '127.0.0.1'
   //  ];
   // $client = new Client($clientObj);
   // $users = $client->getAllUsers();
   // $this->assertEquals("SynapseException", get_class($users) );

}

public function testGetUser()
{
//checking for no errors
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '|123456',
//   'ip_address' => '127.0.0.1',
//   'full_dehydrate' => 'True'
// ];
// $client = new Client($clientObj);
//
// $testObj = $client->getUser('5bfc547cbaabfc00b46ffd00');
// $this->assertEquals(True, is_string($testObj->oauth));
// $this->assertEquals(True, is_string($testObj->id));
// $this->assertEquals(True, is_object($testObj->payload));
// $this->assertEquals(True, is_object($testObj->headersObj));

//'This raises a cannot be found error';
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '|123456',
//   'ip_address' => '127.0.0.1',
//   'full_dehydrate' => 'True'
// ];
// $client = new Client($clientObj);
// $testObj = $client->getUser('5bfc547cbaabfc00b46ffd0');
// $this->assertEquals("SynapseException", get_class($testObj) );

//'Bad request to API. Missing a field or an invalid field';
// $clientObj = (object) [
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '|123456',
//   'ip_address' => '127.0.0.1',
//   'full_dehydrate' => 'True'
// ];
// $client = new Client($clientObj);
// $testObj = $client->getUser('5bfc547cbaabfc00b46ffd00');
// $this->assertEquals("SynapseException", get_class($testObj) );

}

public function testCreateUser()
{
//http_code = 200
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '|123456',
//   'ip_address' => '127.0.0.1',
//   'full_dehydrate' => 'True'
// ];
// $logins_object = (object) [
//   'email' => 'mr.t@synapsefi.com',
//   'password' => 'mr.tlovessynapsefi',
//   'scope' => 'READ_AND_WRITE'
// ];
// $legalnames_array = array();
// $legalnames_array[] = 'Mr.T';
// $phoneNumbers_array = array();
// $phoneNumbers_array[] = '777.111.1111';
//
// $client = new Client($clientObj);
// $testObj = $client->createUser($logins_object, $phoneNumbers_array, $legalnames_array );
//
// $this->assertEquals(True, is_string($testObj->oauth));
// $this->assertEquals(True, is_string($testObj->id));
// $this->assertEquals(True, is_object($testObj->payload));
// $this->assertEquals(True, is_object($testObj->headersObj));

//http_code = 400 'Bad request to API. Missing a field or an invalid field';
// $clientObj = (object) [
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '|123456',
// ];
// $client = new Client($clientObj);
// $logins_object = (object) [
// 'email' => 'tariqanees@synapsefi.com',
// 'password' => 'tariqaneeslosvessynapsefi',
// 'scope' => 'READ_AND_WRITE'
// ];
// $legalnames_array = array();
// $legalnames_array[] = 'Tariq Anees';
// $phoneNumbers_array = array();
// $phoneNumbers_array[] = '408.111.1111';
//
// $testObj = $client->createUser($logins_object, $phoneNumbers_array, $legalnames_array);
// $this->assertEquals("SynapseException", get_class($testObj) );
}


public function testCreateNode()
{
//http_code = 200
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '|123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $getuserobj =  $client->getUser('5bfc547cbaabfc00b46ffd00');
// $returnObj = (object) [
//   'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'XSPUSERIP' => '127.0.0.1',
//   'XSPUSER' => '|123456',
//   'id' => '5bfc547cbaabfc00b46ffd00',
//   'payload' => $getuserobj->payload,
//   'oauth' => $getuserobj->oauth,
//   'ContentType' => 'application/json'
// ];
// $user = new User($returnObj);
// $info = (object) [
//   'nickname' => 'Mr.Rogers favorite account'
// ];
// $deposit_account_object = (object) [
//   'type' => 'DEPOSIT-US',
//   'info' => $info
// ];
//
// $depositaccount = $getuserobj->createDepositAccounts($deposit_account_object);
// //var_dump($depositaccount);
// $this->assertEquals(True, is_string($depositaccount->node_id));
// $this->assertEquals(True, is_string($depositaccount->user_id));
// $this->assertEquals(True, is_string($depositaccount->type));
// $this->assertEquals(True, is_object($depositaccount->body));

//trigger 400, user obj omitted fingerprint and ip
// $clientObj = (object) [
//     'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//     'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//     'fingerprint' => '|123456',
//     'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $info = (object) [
//   'nickname' => 'My Checking'
// ];
// $deposit_account_object = (object) [
//   'type' => 'DEPOSIT-US',
//   'info' => $info
// ];
// $getuser = $client->getUser('5bfc547cbaabfc00b46ffd00');
//   $returnObj = (object) [
//     'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//     'id' => '5bfc547cbaabfc00b46ffd00',
//     'payload' => $getuser->payload,
//     'oauth' => $getuser->oauth,
//     'ContentType' => 'application/json'
//   ];
// $user = new User($returnObj);
//
// $testObj = $user->createDepositAccounts($deposit_account_object);
// $this->assertEquals("SynapseException", get_class($testObj) );

//trigger 401
// $clientObj = (object) [
//     'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//     'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//     'fingerprint' => '|123456',
//     'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $info = (object) [
//   'nickname' => 'My Checking'
// ];
// $deposit_account_object = (object) [
//   'type' => 'DEPOSIT-US',
//   'info' => $info
// ];
// $getuser = $client->getUser('5bfc547cbaabfc00b46ffd00');
//
// $returnObj = (object) [
//   'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'id' => '5bfc547cbaabfc00b46ffd00',
//   'XSPUSERIP' => '127.0.0.1',
//   'XSPUSER' => '|123456',
//   'payload' => $getuser->payload,
//   'ContentType' => 'application/json'
// ];
// $user = new User($returnObj);
// $testObj = $user->createDepositAccounts($deposit_account_object);
// $this->assertEquals("SynapseException", get_class($testObj) );
}



public function testGetNode()
{
//http_code= 200
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '|123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $getuserobj =  $client->getUser('5bfc547cbaabfc00b46ffd00');
//
// $returnObj = (object) [
//   'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'XSPUSERIP' => '127.0.0.1',
//   'XSPUSER' => '|123456',
//   'id' => '5bfc547cbaabfc00b46ffd00',
//   'payload' => $getuserobj->payload,
//   'oauth' => $getuserobj->oauth,
//   'ContentType' => 'application/json'
// ];
// $user = new User($returnObj);
// $getNodeObj = $user->getNode('5bfc7ea3192dde00c2fd9189');
//
// $this->assertEquals(True, is_string($getNodeObj->node_id));
// $this->assertEquals(True, is_string($getNodeObj->user_id));
// $this->assertEquals(True, is_string($getNodeObj->type));
// $this->assertEquals(True, is_object($getNodeObj->body));

//trigger 404, incorrect userid
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '|123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $getuserobj =  $client->getUser('5bfc547cbaabfc00b46ffd00');
//
// $returnObj = (object) [
//   'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'XSPUSERIP' => '127.0.0.1',
//   'XSPUSER' => '|123456',
//   'id' => '5bfc547cbaabfc00b46ffd00',
//   'payload' => $getuserobj->payload,
//   'oauth' => $getuserobj->oauth,
//   'ContentType' => 'application/json'
// ];
// $user = new User($returnObj);
// $getNodeObj = $user->getNode('5bfefe49192dde00c3fdebd');
// $this->assertEquals("SynapseException", get_class($getNodeObj) );


//trigger 400
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '|123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $getuserobj =  $client->getUser('5bfc547cbaabfc00b46ffd00');
//
// $returnObj = (object) [
//   'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'id' => '5bfc547cbaabfc00b46ffd00',
//   'payload' => $getuserobj->payload,
//   'oauth' => $getuserobj->oauth,
//   'ContentType' => 'application/json'
// ];
// $user = new User($returnObj);
// $getNodeObj = $user->getNode('5bfefe49192dde00c3fdebd1');
//
// $this->assertEquals("SynapseException", get_class($getNodeObj) );
}

public function testCreateSubscription()
{
//trigger 200
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '|123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
//
// $subarray = array();
// $subarray[] = "USERS|POST";
// $subarray[] = "USER|PATCH";
//
// $subarray[] = "NODES|POST";
// $subarray[] = "NODE|PATCH";
//
// $subarray[] = "TRANS|POST";
// $subarray[] = "TRAN|PATCH";
//
//
// $subscriptionOBJ = (object) [
// "scope" => $subarray,
// "url" => "https://requestb.in/zp216zzp"
// ];
//
// $payload = $client->createSubscription($subscriptionOBJ);
// $this->assertEquals(True, is_string($payload->id));
// $this->assertEquals(True, is_string($payload->url));
// $this->assertEquals(True, is_object($payload->body));


//trigger 400
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
//
// $subarray = array();
// $subarray[] = "USERS|POST";
// $subarray[] = "USER|PATCH";
//
// $subarray[] = "NODES|POST";
// $subarray[] = "NODE|PATCH";
//
// $subarray[] = "TRANS|POST";
// $subarray[] = "TRAN|PATCH";
//
// $subscriptionOBJ = (object) [
// "scope" => $subarray,
// "url" => "https://requestb.in/zp216zzp"
// ];
//
// $payload = $client->createSubscription($subscriptionOBJ);
// $this->assertEquals("SynapseException", get_class($payload) );
}

public function testGetSubscription()
{
//http_code 200
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '|123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
//
// $newSubObj = $client->getSubscription('5bfc8c1e74d505009543b084');
// $this->assertEquals(True, is_string($newSubObj->id));
// $this->assertEquals(True, is_string($newSubObj->url));
// $this->assertEquals(True, is_object($newSubObj->body));

//http_code 400 client secret is omitted
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'fingerprint' => '|123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $payload = $client->getSubscription('5bfc8c1e74d505009543b084');
// $this->assertEquals("SynapseException", get_class($payload) );
}

public function testGetPublicKey(){
// raises 200 status code
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '|123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $scope = array();
// $scope[] = 'USERS|GET';
// $payload = $client->getPublicKey('YES', 'scope=USERS|GET');
// $this->assertEquals(True, is_object($payload));

// //raise http code 400 ommited client secret
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'fingerprint' => '|123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $scope = array();
// $scope[] = 'USERS|GET';
// $payload = $client->getPublicKey('YES', 'scope=USERS|GET');
//
//
//  $this->assertEquals("SynapseException", get_class($payload) );
}

public function testAddUserKYC()
{
//raises a 200 status code
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '|123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
//
// $getuser = $client->getUser("5bfc547cbaabfc00b46ffd00");
// $data = array("name"=>"MRMR.ROGERSROGERS", "phone_number"=>"999.111.1111", 'email' => "MR.ROGERS@test.com");
// $addNewDocs = $getuser->addUserKYC($data);
//
// $this->assertEquals(True, is_object($addNewDocs));

//raises a 400 status code ommitted user's client id and client secret
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '|123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $getuser = $client->getUser("5bfc547cbaabfc00b46ffd00");
// $returnObj = (object) [
//   //'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'XSPUSERIP' => '127.0.0.1',
//   'XSPUSER' => '|123456',
//   'id' => '5bfc547cbaabfc00b46ffd00',
//   'payload' => $getuser->payload,
//   'oauth' => $getuser->oauth,
//   'ContentType' => 'application/json'
// ];
// $user = new User($returnObj);
//
// $data = array("name"=>"MR.ROGERS", "phone_number"=>"999.111.1111", 'email' => "MR.ROGERS@test.com");
// $addNewDocs = $user->addUserKYC($data);
// $this->assertEquals("SynapseException", get_class($addNewDocs) );
}

public function testGetInstitution(){
//raises a 200 http status code
    // $clientObj = (object) [
    //   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
    //   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
    //   'fingerprint' => '|123456',
    //   'ip_address' => '127.0.0.1'
    // ];
    // $client = new Client($clientObj);
    // $getInst=  $client->getInstitution();
    //
    // $this->assertEquals(True, is_object($getInst));
}

public function testUpdateExistingDocs()
{
//http_status code 200
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '|123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $getuser = $client->getUser("5bfc547cbaabfc00b46ffd00");
// $data = array("name"=>"MR.ROGERS", "phone_number"=>"999.111.1111", 'email' => "MR.ROGERS@test.com");
// $addNewDocs = $getuser->updateUser($data);
// $this->assertEquals(True, is_object($addNewDocs));

//http_status code 400
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '|123456',
//   'ip_address' => '127.0.0.1'
// ];
//
// $client = new Client($clientObj);
// $getuser = $client->getUser("5bfc547cbaabfc00b46ffd00");
// $returnObj = (object) [
//   //'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'XSPUSERIP' => '127.0.0.1',
//   'XSPUSER' => '|123456',
//   'id' => '5bfc547cbaabfc00b46ffd00',
//   'payload' => $getuser->payload,
//   'oauth' => $getuser->oauth,
//   'ContentType' => 'application/json'
// ];
//
// $user = new User($returnObj);
// $data = array("name"=>"MR.ROGERS", "phone_number"=>"999.111.1111", 'email' => "MR.ROGERS@test.com");
// $addNewDocs = $user->updateUser($data);
// $this->assertEquals("SynapseException", get_class($addNewDocs) );
}


public function testDeleteExistingDocs(){
//http_status code = 200
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '|123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $getuser = $client->getUser("5bfc547cbaabfc00b46ffd00");
// $deletedocsbody = array("id"=>'5bfc547cbaabfc00b46ffd00', 'permission_scope' => "DELETE_DOCUMENT");
// $addNewDocs = $getuser->deleteDocuments($deletedocsbody);
// $this->assertEquals(True, is_object($addNewDocs));

//http_status code 401, omitted Authentication error
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '|123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $getuser = $client->getUser("5bfc547cbaabfc00b46ffd00");
// $returnObj = (object) [
//   'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//    'XSPUSERIP' => '127.0.0.1',
//    'XSPUSER' => '|123456',
//    'id' => '5bfc547cbaabfc00b46ffd00',
//   'payload' => $returnObj->payload,
//   //'oauth' => $returnObj->oauth,
//   'ContentType' => 'application/json'
// ];
//
// $user = new User($returnObj);
// $deletedocsbody = array("id"=>'5bfc547cbaabfc00b46ffd00', 'permission_scope' => "DELETE_DOCUMENT");
// $delDocs = $user->deleteDocuments($deletedocsbody);
// var_dump("http_code", $delDocs->http_code);
// $this->assertEquals("SynapseException", get_class($delDocs) );

//http_status code 400
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '|123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $getuser = $client->getUser("5bfc547cbaabfc00b46ffd00");
// $returnObj = (object) [
//   //'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//    'XSPUSERIP' => '127.0.0.1',
//    'XSPUSER' => '|123456',
//    'id' => '5bfc547cbaabfc00b46ffd00',
//   'payload' => $returnObj->payload,
//   'oauth' => $returnObj->oauth,
//   'ContentType' => 'application/json'
// ];
//
// $user = new User($returnObj);
// $deletedocsbody = array("id"=>'5bfc547cbaabfc00b46ffd00', 'permission_scope' => "DELETE_DOCUMENT");
// $delDocs = $user->deleteDocuments($deletedocsbody);
// $this->assertEquals("SynapseException", get_class($delDocs) );
}

public function testUpdateUser(){
//http_status code 200
      // $clientObj = (object) [
      //   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
      //   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
      //   'fingerprint' => '|123456',
      //   'ip_address' => '127.0.0.1'
      // ];
      //
      // $client = new Client($clientObj);
      // $getuser = $client->getUser("5bfc547cbaabfc00b46ffd00");
      //
      // $data = array("name"=>"MR.ROGERS", "phone_number"=>"999.111.1111", 'email' => "MR.ROGERS@test.com");
      // $addNewDocs = $getuser->updateUser($data);
      //
      //
      // $this->assertEquals(True, is_object($addNewDocs));

//http_status code 401, ommite oauth
//       $clientObj = (object) [
//         'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//         'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//         'fingerprint' => '|123456',
//         'ip_address' => '127.0.0.1'
//       ];
//       $client = new Client($clientObj);
//       $getuser = $client->getUser("5bfc547cbaabfc00b46ffd00");
//       $returnObj = (object) [
//         'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//          'XSPUSERIP' => '127.0.0.1',
//          'XSPUSER' => '|123456',
//          'id' => '5bfc547cbaabfc00b46ffd00',
//         'payload' => $getuser->payload,
//       //  'oauth' => $getuser->oauth,
//         'ContentType' => 'application/json'
//       ];
//       $user = new User($returnObj);
//       $data = array("name"=>"MR.ROGERS", "phone_number"=>"999.111.1111", 'email' => "MR.ROGERS@test.com");
//       $addNewDocs = $user->updateUser($data);
//       var_dump("add new docs failure", $addNewDocs);
//       $this->assertEquals("Authentication Error", $addNewDocs);

//http_status code 400, ommitted clientid and client secret
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '|123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $getuser = $client->getUser("5bfc547cbaabfc00b46ffd00");
// $returnObj = (object) [
//   //'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//    'XSPUSERIP' => '127.0.0.1',
//    'XSPUSER' => '|123456',
//    'id' => '5bfc547cbaabfc00b46ffd00',
//   'payload' => $getuser->payload,
//   'oauth' => $getuser->oauth,
//   'ContentType' => 'application/json'
// ];
// $user = new User($returnObj);
// $data = array("name"=>"MR.ROGERS", "phone_number"=>"999.111.1111", 'email' => "MR.ROGERS@test.com");
// $addNewDocs = $user->updateUser($data);
// $this->assertEquals("Bad request to API. Missing a field or an invalid field", $addNewDocs);
}


}
?>
