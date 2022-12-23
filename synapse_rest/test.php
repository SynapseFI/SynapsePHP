<?php
include 'client.php';
// require 'vendor/autoload.php';
//include 'Subscription.php';
use \Mockery as m;
use PHPUnit\Framework\TestCase;
//require_once ('PHPUnit/Framework/TestCase.php');


//../vendor/bin/phpunit test.php

Class Test extends TestCase
{
//  public function testLocalAtms(){
//  $zip = 94114;
//  $lat = null;
//  $lon = null;
//  $radius = 5;
//  $page = 1;
//  $per_page = 1;

//  $clientObj = (object) [
//      'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//      'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//      'fingerprint' => '123456',
//      'ip_address' => '127.0.0.1',
//      'devmode' => True,
//      'printToConsole' => True,
//      'handle202' => True
//  ];
//  $client = new Client($clientObj);
//  //$atms = $client->locate_atms($zip , $lat , $lon , $radius , $page , $per_page );
//  $atms = $client->locate_atms($zip , null , null , $radius , $page , $per_page );
//  $this->assertEquals(True, is_object($atms));
//  }

//  public function testGetCryptoQuotes(){
//  $clientObj = (object) [
//      'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//      'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//      'fingerprint' => '123456',
//      'ip_address' => '127.0.0.1',
//      'devmode' => True,
//      'printToConsole' => True,
//      'handle202' => True
//    ];
//  $client = new Client($clientObj);
//  $cyrptoquotes = $client->get_crypto_quotes();
//  $this->assertEquals(True, is_object($cyrptoquotes));
//  }

// public function testGetCryptoMarketData(){
//  $clientObj = (object) [
//      'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//      'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//      'fingerprint' => '123456',
//      'ip_address' => '127.0.0.1',
//      'devmode' => True,
//      'printToConsole' => True,
//      'handle202' => True
//    ];
//  $client = new Client($clientObj);
//  $limit = 5;
//  $currency = "BTC";
 
//  $marketdata = $client->get_crypto_market_data($limit, $currency);
//  var_dump($marketdata);
//  $this->assertEquals(True, is_object($marketdata));
// }

//  public function testCreateSubnet(){
//   $clientObj = (object) [
//       'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//       'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//       'fingerprint' => '123456',
//       'ip_address' => '127.0.0.1',
//       'devmode' => True,
//       'printToConsole' => True,
//       'handle202' => True
//     ];
//     $client = new Client($clientObj);
//     $user = $client->get_user('5c0199fe3c4e280a7d7c2a31');
//     $body = (object)[
//       "nickname" => "Test AC/RT"
//     ];
//   $obj = $user->create_subnet('5c0abc754f98b000bc81c0ca', $body);
//   $this->assertEquals(True, is_object($obj));

//  }
// //
//  public function testGetSubnet(){
//   $clientObj = (object) [
//       'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//       'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//       'fingerprint' => '123456',
//       'ip_address' => '127.0.0.1',
//       'devmode' => True,
//       'printToConsole' => True,
//       'handle202' => True
//     ];
//     $client = new Client($clientObj);
//     $user = $client->get_user('5c0199fe3c4e280a7d7c2a31');
//     $subnet = $user->get_subnet('5c0abc754f98b000bc81c0ca', '59c9f77cd412960028b99d2b' );
//     $this->assertEquals(True, is_object($subnet));
// }

// public function testDeleteTransaction(){
//     $clientObj = (object) [
//         'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//         'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//         'fingerprint' => '123456',
//         'ip_address' => '127.0.0.1',
//         'devmode' => True,
//         'printToConsole' => True,
//         'handle202' => True
//       ];
//       $client = new Client($clientObj);
//       $user = $client->get_user('5c0199fe3c4e280a7d7c2a31');
//       $del = $user->delete_trans('5c0abc754f98b000bc81c0ca', '5c1442487bedaa008a4a347b');
//       $this->assertEquals(True, is_object($del));
// }

// public function testDisputeTransaction(){
//   $clientObj = (object) [
//       'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//       'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//       'fingerprint' => '123456',
//       'ip_address' => '127.0.0.1',
//       'devmode' => True,
//       'printToConsole' => True,
//       'handle202' => True
//     ];
//     $client = new Client($clientObj);
//     $user = $client->get_user('5c0199fe3c4e280a7d7c2a31');
//     $disputeobj = (object)[
//       "dispute_reason" => "CHARGE_BACK"
//     ];
//     $disp = $user->dispute_trans('5c0abc754f98b000bc81c0ca', '5c1442487bedaa008a4a347b', $disputeobj);
//     $this->assertEquals(True, is_object($disp));
// }

// public function testCommentTransaction(){
//     $clientObj = (object) [
//         'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//         'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//         'fingerprint' => '123456',
//         'ip_address' => '127.0.0.1',
//         'devmode' => True,
//         'printToConsole' => True,
//         'handle202' => True
//       ];
//       $client = new Client($clientObj);
//       $user = $client->get_user('5c0199fe3c4e280a7d7c2a31');
//       $body = (object)[
//         "comment" => "add comment"
//       ];
//       $trans = $user->comment_trans($body);
//       $this->assertEquals(True, is_object($trans));
// }

// public function testDummyTransaction(){
//     $clientObj = (object) [
//       'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//       'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//       'fingerprint' => '123456',
//       'ip_address' => '127.0.0.1',
//       'devmode' => True,
//       'printToConsole' => True,
//       'handle202' => True
//     ];
//     $client = new Client($clientObj);
//     $user = $client->get_user('5c0199fe3c4e280a7d7c2a31');
//     $trans = $user->dummy_tran('5c0af7541cfe2300a0fe477b');
//     $this->assertEquals(True, is_object($trans));
//  }
//  public function testCreateTransaction(){
//     $clientObj = (object) [
//       'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//       'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//       'fingerprint' => '123456',
//       'ip_address' => '127.0.0.1',
//       'devmode' => True,
//       'printToConsole' => True,
//       'handle202' => True
//     ];
//     $client = new Client($clientObj);
//     $user = $client->get_user('5c0199fe3c4e280a7d7c2a31');
//     $to = (object)[
//       "type" => "ACH-US",
//       "id" =>'5c05ae9fce316700ab2a571f'
//     ];
//     $amount = (object)[
//       "amount" => 22.1,
//       "currency" => "USD"
//     ];
//     $extra = (object)[
//       "ip" => "127.0.0.1"
//     ];
//     $transbody = (object)[
//       "to" => $to,
//       "amount" => $amount,
//       "extra" => $extra
//     ];
//     $trans = $user->create_trans($transbody);
//     $this->assertEquals(True, is_object($trans));
// }

// public function testGetTransaction(){
//   $clientObj = (object) [
//     'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//     'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//     'fingerprint' => '123456',
//     'ip_address' => '127.0.0.1',
//     'devmode' => True,
//     'printToConsole' => True,
//     'handle202' => True
//   ];
//   $client = new Client($clientObj);
//   $user = $client->get_user('5c0199fe3c4e280a7d7c2a31');
//   $trans = $user->get_trans('5c0af7541cfe2300a0fe477b', '5c13fb0c6a81c9008bc4b2bd');
//   $this->assertEquals(True, is_object($trans));
// }

// public function testVerifyMicro(){
//   $clientObj = (object) [
//     'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//     'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//     'fingerprint' => '123456',
//     'ip_address' => '127.0.0.1',
//     'devmode' => True,
//     'printToConsole' => True,
//     'handle202' => True
//   ];
//   $client = new Client($clientObj);
//   $user = $client->get_user('5c0199fe3c4e280a7d7c2a31');
//   $micro = (object)[0.1,0.1];
//   $verifymicro = $user->verify_micro('5c0af7541cfe2300a0fe477b', $micro);
//   $this->assertEquals(True, is_object($verifymicro));
// }

// public function testShipDebit(){
//   $clientObj = (object) [
//     'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//     'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//     'fingerprint' => '123456',
//     'ip_address' => '127.0.0.1',
//     'devmode' => True,
//     'printToConsole' => True,
//     'handle202' => True
//   ];
//   $client = new Client($clientObj);
//   $user = $client->get_user('5c0199fe3c4e280a7d7c2a31');
//   $ship = (object)[
//     "fee_node_id" =>"5c05a5b0ce316700ab2a568a",
//     "expedite" => True
//   ];
//   $shipdebit = $user->ship_debit('5c0af7541cfe2300a0fe477b', $ship);
//   $this->assertEquals(True, is_object($shipdebit));
//  }

// public function testReinitMicro(){
//   $clientObj = (object) [
//     'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//     'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//     'fingerprint' => '123456',
//     'ip_address' => '127.0.0.1',
//     'devmode' => True,
//     'printToConsole' => True,
//     'handle202' => True
//   ];
//   $client = new Client($clientObj);
//   $user = $client->get_user('5c0199fe3c4e280a7d7c2a31');
//   $shipdebit = $user->reinit_micro('5c0af7541cfe2300a0fe477b');
//   $this->assertEquals(True, is_object($shipdebit));
// }

// public function testCreateUbo(){
//   $clientObj = (object) [
//     'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//     'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//     'fingerprint' => '123456',
//     'ip_address' => '127.0.0.1',
//     'devmode' => True,
//     'printToConsole' => True,
//     'handle202' => True
//   ];
//   $client = new Client($clientObj);
//   $user = $client->get_user('5c0199fe3c4e280a7d7c2a31');
//   $entity = (object) [
//     "cryptocurrency" => True,
//     "gambling" => False,
//     "document_id" => "2a4a5957a3a62aaac1a0dd0edcae96ea2cdee688ec6337b20745eed8869e3ac8"
//   ];
//   $signer = (object) [
//     "relationship_to_entity" => "CEO",
//     "document_id" => "2a4a5957a3a62aaac1a0dd0edcae96ea2cdee688ec6337b20745eed8869e3ac8"
//   ];
//   $compliance = (object) [
//     "relationship_to_entity" => "CEO",
//     "document_id" => "2a4a5957a3a62aaac1a0dd0edcae96ea2cdee688ec6337b20745eed8869e3ac8"
//   ];
//   $primary = (object) [
//     "relationship_to_entity" => "CEO",
//     "document_id" => "2a4a5957a3a62aaac1a0dd0edcae96ea2cdee688ec6337b20745eed8869e3ac8"
//   ];
//   $entitydoc = (object)[
//     "entity_info" => $entity,
//     "signer" => $signer,
//     "compliance_contact" => $compliance,
//     "primary_controlling_contact" => $primary
//   ];

//   $ubo = $user->create_ubo($entitydoc);
//   $this->assertEquals(True, is_object($ubo));
//  }


// public function testUpdateNode(){
//   $clientObj = (object) [
//     'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//     'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//     'fingerprint' => '123456',
//     'ip_address' => '127.0.0.1',
//     'devmode' => True,
//     'printToConsole' => True,
//     'handle202' => True
//   ];
//   $client = new Client($clientObj);
//   $user = $client->get_user('5c0199fe3c4e280a7d7c2a31');

//   $updateBody = (object) [
//     "supp_id"=>"new_supp_id_1234"
//   ];
//   $testObj = $user->update_node('5c37c1245111230061707492', $updateBody);
//   var_dump($testObj);
//   $this->assertEquals("Node", get_class($testObj));
//   $this->assertEquals(True, is_object($testObj));


//   $updateBody = (object) [ ];
//   $testObj = $user->update_node('5c37c1245111230061707492', $updateBody);
//   // var_dump($testObj);
//   $this->assertEquals("SynapseException", get_class($testObj));
// }

// public function testCreateNodeACHMFA(){
// $clientObj = (object) [
//     'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//     'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//     'fingerprint' => '123456',
//     'ip_address' => '127.0.0.1',
//     'devmode' => True,
//     'printToConsole' => True,
//     'handle202' => False
//   ];
//   $client = new Client($clientObj);
//   $user = $client->get_user('5c0199fe3c4e280a7d7c2a31');
// // create node with mfa flow
//   $infoachus = (object)[
//     "bank_id" => "synapse_good",
//     "bank_pw" => "test1234",
//     "bank_name" => "jan14thachus"
//   ];
//   $ach = (object) [
//     "type" => "ACH-US",
//     "info" => $infoachus
//   ];
//   $testObj = $user->create_node($ach);
//   var_dump($testObj);
// //submit mfa answer
//   $access = (object)[
//     "access_token"=>"fake_cd60680b9addc013ca7fb25b2b704be324d0295b34a6e3d14473e3cc65aa82d3",
//     "mfa_answer"=>"test_answer"
//   ];
//   $testObj = $user->create_node($access);
//   var_dump($testObj);
// // create node without mfa flow
//   $infoachus = (object)[
//     "nickname" => "DEC14thAchNodes",
//     "account_num" => "1232225674134",
//     "routing_num" => "051000017",
//     "type" => "PERSONAL",
//     "class" => "CHECKING"
//   ];
//   $ach = (object) [
//     "type" => "ACH-US",
//     "info" => $infoachus
//   ];
//   $testObj = $user->create_node($ach);
//   var_dump($testObj);
//   $this->assertEquals(True, is_string($testObj->node_id));
//   $this->assertEquals('5c0199fe3c4e280a7d7c2a31', ($testObj->user_id));
//   $this->assertEquals('Node', get_class($testObj->body));
//   $achfail = (object) [
//   ];
//   $testObj = $user->createNode($achfail);
//   $this->assertEquals("SynapseException", get_class($testObj));

// }

// public function testDeleteNode(){
//     $clientObj = (object) [
//       'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//       'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//       'fingerprint' => '123456',
//       'ip_address' => '127.0.0.1',
//       'devmode' => True,
//       'printToConsole' => True,
//       'handle202' => True
//     ];
//     $client = new Client($clientObj);
//     $user = $client->get_user('5c0199fe3c4e280a7d7c2a31');
//     $testObj = $user->delete_node('5c0af7541cfe2300a0fe477b');
//     $this->assertEquals(True, is_object($testObj));
//  }
// //
//  public function testCreateNodeMFA(){
//   $clientObj = (object) [
//     'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//     'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//     'fingerprint' => '123456',
//     'ip_address' => '127.0.0.1',
//     'full_dehydrate' => 'True'
//   ];
//   $client = new Client($clientObj);
//   $user = $client->$getUser('5c0199fe3c4e280a7d7c2a31');
//   $mfa = (object) [
//     "access_token" => "fake_cd60680b9addc013ca7fb25b2b70",
//     "mfa_answer"=>"test_answer"
//   ];
//   $testObj = $user->createNodeMFA($mfa);
//   if($testObj->http_code == '202'){
//   $this->assertEquals(True, is_string($testObj->$mfa->access_token));
//   $this->assertEquals(True, is_string($testObj->$mfa->message));
//   }
//   if($testObj->http_code == '200'){
//   $this->assertEquals(True, is_object($testObj));
//   }

//   $achfail = (object) [
//   ];
//   $testObj = $user->createNode($achfail);
//   $this->assertEquals("SynapseException", get_class($testObj));

// }

//  public function testResetDebitCard(){
//   $clientObj = (object) [
//     'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//     'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//     'fingerprint' => '123456',
//     'ip_address' => '127.0.0.1',
//     'full_dehydrate' => 'True'
//   ];
//   $client = new Client($clientObj);
//   $user = $client->get_user('5c0199fe3c4e280a7d7c2a31');
//   $reset = (object) [];
//   $testObj = $user->reset_debit($reset, '5c0abc754f98b000bc81c0ca');
//   $this->assertEquals(True, is_object($testObj));

//   $returnObj = (object) [
//     //'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//     'XSPUSERIP' => '127.0.0.1',
//     'XSPUSER' => '123456',
//     'id' => '5bfc547cbaabfc00b46ffd00',
//     'payload' => $user->payload,
//     'oauth' => $user->oauth,
//     'ContentType' => 'application/json',
//     'fingerprint' => '123456'
//   ];

//   $newuser = new User($returnObj);
//   $testObj = $newuser->resetDebitCard($reset, '5c0abc754f98b000bc81c0ca');
//   $this->assertEquals("SynapseException", get_class($testObj));
// }

// public function testGenerateApplePay(){
//   $clientObj = (object) [
//     'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//     'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//     'fingerprint' => '123456',
//     'ip_address' => '127.0.0.1',
//     'full_dehydrate' => 'True'
//   ];
//   $client = new Client($clientObj);
//   $user = $client->$get_user('5be4e2b16f467000bb16e9c7');
//   $body = (object)[
//     "certificate" => "your applepay cert",
//     "nonce" => "9c02xxx2",
//     "nonce_signature" => "4082f883ae62d0700c283e225ee9d286713ef74"
//   ];
//   $result = $user->generate_apple_pay('5c0abc754f98b000bc81c0ca', $body);
//   $this->assertEquals(True, is_string($result->data));
//   $this->assertEquals(True, is_string($result->public_key));


//   $result = $user->generate_apple_pay('5c0abc754f98b000bc81c0ca', $body);
//   $this->assertEquals("SynapseException", get_class($result));


// }

// public function testGetAllPlatformNodes(){
//   // http status code 200
//   $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1'
//    ];
//   $client = new Client($clientObj);
//   $nodes = $client->get_all_nodes();
  
//   $this->assertEquals(True, is_array($nodes->list_of_nodes));
//   $this->assertEquals(True, is_int($nodes->nodes_count));
//   $this->assertEquals(True, is_int($nodes->limit));
//   $this->assertEquals(True, is_int($nodes->page));
//   $this->assertEquals(True, is_int($nodes->page_count));

//   // trigger 400 ommit client secret
//   $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1'
//    ];
//   $client = new Client($clientObj);
//   $nodes = $client->get_all_nodes();
//   $this->assertEquals("SynapseException", get_class($nodes) );
// }

// public function testGetAllSubscriptions()
// {
//   // http status code 200
//   $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1'
//    ];
//   $client = new Client($clientObj);
//   $subs = $client->get_all_subscriptions();
  
//   $this->assertEquals(True, is_array($subs->list_of_subs));
//   $this->assertEquals(True, is_int($subs->subscriptions_count));
//   $this->assertEquals(True, is_int($subs->limit));
//   $this->assertEquals(True, is_int($subs->page));
//   $this->assertEquals(True, is_int($subs->page_count));

//   // trigger 400 ommit client secret
//   $clientObj = (object) [
//   //'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1'
//    ];
//   $client = new Client($clientObj);
//   $subs = $client->get_all_subscriptions();
//   $this->assertEquals("SynapseException", get_class($subs) );
// }

// public function testGetAllTransactions()
// {
//     //  http status code 200
//      $clientObj = (object) [
//      'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//      'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//      'fingerprint' => '123456',
//      'ip_address' => '127.0.0.1'
//       ];
//      $client = new Client($clientObj);
//      $trans = $client->get_all_transactions();
     
//      $this->assertEquals(True, is_array($trans->list_of_trans));
//      $this->assertEquals(True, is_int($trans->trans_count));
//      $this->assertEquals(True, is_int($trans->limit));
//      $this->assertEquals(True, is_int($trans->page));
//      $this->assertEquals(True, is_int($trans->page_count));

//     //  trigger a 400 error by ommitting the client secret
//      $clientObj = (object) [
//        // 'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//      'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//      'fingerprint' => '123456',
//      'ip_address' => '127.0.0.1'
//       ];
//      $client = new Client($clientObj);
//      $trans = $client->get_all_transactions();
//      $this->assertEquals("SynapseException", get_class($trans) );
// }


// public function testGetAllUsers()
// {
//   //  http status code 200
//    $clientObj = (object) [
//    'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//    'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//    'fingerprint' => '123456',
//    'ip_address' => '127.0.0.1'
//     ];
//    $client = new Client($clientObj);
//    $users = $client->get_all_users();
   
//    var_dump("users ", $users);
//    //var_dump("users count ", $users->$users_count);
//    $this->assertEquals(True, is_int($users->users_count));
//    $this->assertEquals(True, is_array($users->list_of_users));
//    $this->assertEquals(True, is_int($users->limit));
//    $this->assertEquals(True, is_int($users->page));
//    $this->assertEquals(True, is_int($users->page_count));

//   //  trigger a 400 error by ommitting the client secret
//    $clientObj = (object) [
//    //'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//    'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//    'fingerprint' => '123456',
//    'ip_address' => '127.0.0.1'
//     ];
//    $client = new Client($clientObj);
//    $users = $client->get_all_users();
//    $this->assertEquals("SynapseException", get_class($users) );

// }

// public function testGetUser()
// {
// // checking for no errors
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1',
//   'full_dehydrate' => 'True'
// ];
// $client = new Client($clientObj);
// $testObj = $client->get_user('5bfc547cbaabfc00b46ffd00');
// $this->assertEquals(True, is_string($testObj->oauth));
// $this->assertEquals(True, is_string($testObj->id));
// $this->assertEquals(True, is_object($testObj->payload));
// $this->assertEquals(True, is_object($testObj->headersObj));
// // 'This raises a cannot be found error';
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1',
//   'full_dehydrate' => 'True'
// ];
// $client = new Client($clientObj);
// $testObj = $client->get_user('5bfc547cbaabfc00b46ffd0');
// $this->assertEquals("SynapseException", get_class($testObj) );

// // 'Bad request to API. Missing a field or an invalid field';
// $clientObj = (object) [
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1',
//   'full_dehydrate' => 'True'
// ];
// $client = new Client($clientObj);
// $testObj = $client->get_user('5bfc547cbaabfc00b46ffd00');
// $this->assertEquals("SynapseException", get_class($testObj) );

// }

public function testCreateUser()
{
// http_code = 200
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

$this->assertEquals(True, is_string($testObj->oauth));
$this->assertEquals(True, is_string($testObj->id));

if(isset($testObj->payload)){
  $this->assertEquals(True, is_object($testObj->payload));
}

if(isset($testObj->payload)){
  $this->assertEquals(True, is_object($testObj->headersObj));
}



// http_code = 400 'Bad request to API. Missing a field or an invalid field';
// $clientObj = (object) [
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '123456',
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

// $testObj = $client->create_user($logins_object, $phoneNumbers_array, $legalnames_array);
// $this->assertEquals("SynapseException", get_class($testObj) );
}


// public function testCreateNode()
// {
// // http_code = 200
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $getuserobj =  $client->get_user('5bfc547cbaabfc00b46ffd00');
// $returnObj = (object) [
//   'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'XSPUSERIP' => '127.0.0.1',
//   'XSPUSER' => '123456',
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

// $depositaccount = $getuserobj->create_node($deposit_account_object);
// //var_dump($depositaccount);
// $this->assertEquals(True, is_string($depositaccount->node_id));
// $this->assertEquals(True, is_string($depositaccount->user_id));
// $this->assertEquals(True, is_string($depositaccount->type));
// $this->assertEquals(True, is_object($depositaccount->body));

// // trigger 400, user obj omitted fingerprint and ip
// $clientObj = (object) [
//     'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//     'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//     'fingerprint' => '123456',
//     'ip_address' => '127.0.0.1',
// ];
// $client = new Client($clientObj);
// $info = (object) [
//   'nickname' => 'My Checking'
// ];
// $deposit_account_object = (object) [
//   'type' => 'DEPOSIT-US',
//   'info' => $info
// ];
// $getuser = $client->get_user('5bfc547cbaabfc00b46ffd00');
//   $returnObj = (object) [
//     'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//     'id' => '5bfc547cbaabfc00b46ffd00',
//     'payload' => $getuser->payload,
//     'oauth' => $getuser->oauth,
//     'ContentType' => 'application/json'
//   ];
// $user = new User($returnObj);
// $testObj = $user->create_node($deposit_account_object);
// $this->assertEquals("SynapseException", get_class($testObj) );

// // trigger 401
// $clientObj = (object) [
//     'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//     'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//     'fingerprint' => '123456',
//     'ip_address' => '127.0.0.1',
//     'devmode' => True,
//     'printToConsole' => True,
//     'handle202' => True
// ];
// $client = new Client($clientObj);
// $info = (object) [
//   'nickname' => 'My Checking'
// ];
// $deposit_account_object = (object) [
//   'type' => 'DEPOSIT-US',
//   'info' => $info
// ];
// $getuser = $client->get_user('5bfc547cbaabfc00b46ffd00');

// $returnObj = (object) [
//   'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'id' => '5bfc547cbaabfc00b46ffd00',
//   'XSPUSERIP' => '127.0.0.1',
//   'XSPUSER' => '123456',
//   'payload' => $getuser->payload,
//   'ContentType' => 'application/json'
// ];
// $user = new User($returnObj);
// $testObj = $user->create_node($deposit_account_object);
// $this->assertEquals("SynapseException", get_class($testObj) );
// }


// public function testGetNode()
// {
// // http_code= 200
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $getuserobj =  $client->get_user('5bfc547cbaabfc00b46ffd00');

// $returnObj = (object) [
//   'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'XSPUSERIP' => '127.0.0.1',
//   'XSPUSER' => '123456',
//   'id' => '5bfc547cbaabfc00b46ffd00',
//   'payload' => $getuserobj->payload,
//   'oauth' => $getuserobj->oauth,
//   'ContentType' => 'application/json'
// ];
// $user = new User($returnObj);
// $getNodeObj = $user->get_node('5bfc7ea3192dde00c2fd9189');

// $this->assertEquals(True, is_string($getNodeObj->node_id));
// $this->assertEquals(True, is_string($getNodeObj->user_id));
// $this->assertEquals(True, is_string($getNodeObj->type));
// $this->assertEquals(True, is_object($getNodeObj->body));

// // trigger 404, incorrect userid
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $getuserobj =  $client->get_user('5bfc547cbaabfc00b46ffd00');

// $returnObj = (object) [
//   'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'XSPUSERIP' => '127.0.0.1',
//   'XSPUSER' => '123456',
//   'id' => '5bfc547cbaabfc00b46ffd00',
//   'payload' => $getuserobj->payload,
//   'oauth' => $getuserobj->oauth,
//   'ContentType' => 'application/json'
// ];
// $user = new User($returnObj);
// $getNodeObj = $user->get_node('5bfefe49192dde00c3fdebd');
// $this->assertEquals("SynapseException", get_class($getNodeObj) );

// // trigger 400
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $getuserobj =  $client->get_user('5bfc547cbaabfc00b46ffd00');

// $returnObj = (object) [
//   'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'id' => '5bfc547cbaabfc00b46ffd00',
//   'payload' => $getuserobj->payload,
//   'oauth' => $getuserobj->oauth,
//   'ContentType' => 'application/json'
// ];
// $user = new User($returnObj);
// $getNodeObj = $user->get_node('5bfefe49192dde00c3fdebd1');

// $this->assertEquals("SynapseException", get_class($getNodeObj) );
// }

// public function testCreateSubscription()
// {
// // trigger 200
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);

// $subarray = array();
// $subarray[] = "USERS|POST";
// $subarray[] = "USER|PATCH";

// $subarray[] = "NODES|POST";
// $subarray[] = "NODE|PATCH";

// $subarray[] = "TRANS|POST";
// $subarray[] = "TRAN|PATCH";


// $subscriptionOBJ = (object) [
// "scope" => $subarray,
// "url" => "https://requestb.in/zp216zzp"
// ];

// $payload = $client->create_subscription($subscriptionOBJ);
// $this->assertEquals(True, is_string($payload->id));
// $this->assertEquals(True, is_string($payload->url));
// $this->assertEquals(True, is_object($payload->body));

// // trigger 400
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);

// $subarray = array();
// $subarray[] = "USERS|POST";
// $subarray[] = "USER|PATCH";

// $subarray[] = "NODES|POST";
// $subarray[] = "NODE|PATCH";

// $subarray[] = "TRANS|POST";
// $subarray[] = "TRAN|PATCH";

// $subscriptionOBJ = (object) [
// "scope" => $subarray,
// "url" => "https://requestb.in/zp216zzp"
// ];

// $payload = $client->create_subscription($subscriptionOBJ);
// $this->assertEquals("SynapseException", get_class($payload) );
// }

// public function testGetSubscription()
// {
// // http_code 200
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);

// $newSubObj = $client->get_subscription('5bfc8c1e74d505009543b084');
// $this->assertEquals(True, is_string($newSubObj->id));
// $this->assertEquals(True, is_string($newSubObj->url));
// $this->assertEquals(True, is_object($newSubObj->body));

// // http_code 400 client secret is omitted
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $payload = $client->get_subscription('5bfc8c1e74d505009543b084');
// $this->assertEquals("SynapseException", get_class($payload) );
// }

// public function testIssuePublicKey(){
// // raises 200 status code
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $scope = array();
// $scope[] = 'USERS|GET';
// $payload = $client->issue_public_key('YES', 'scope=USERS|GET');
// $this->assertEquals(True, is_object($payload));

// //raise http code 400 ommited client secret
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $scope = array();
// $scope[] = 'USERS|GET';
// $payload = $client->issue_public_key('YES', 'scope=USERS|GET');


//  $this->assertEquals("SynapseException", get_class($payload) );
// }

// public function testUpdateInfo()
// {
// // raises a 200 status code
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);

// $getuser = $client->get_user("5bfc547cbaabfc00b46ffd00");
// $data = array("name"=>"MRMR.ROGERSROGERS", "phone_number"=>"999.111.1111", 'email' => "MR.ROGERS@test.com");
// $addNewDocs = $getuser->update_info($data);

// $this->assertEquals(True, is_object($addNewDocs));

// // raises a 400 status code ommitted user's client id and client secret
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $getuser = $client->get_user("5bfc547cbaabfc00b46ffd00");
// $returnObj = (object) [
//   //'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'XSPUSERIP' => '127.0.0.1',
//   'XSPUSER' => '123456',
//   'id' => '5bfc547cbaabfc00b46ffd00',
//   'payload' => $getuser->payload,
//   'oauth' => $getuser->oauth,
//   'ContentType' => 'application/json'
// ];
// $user = new User($returnObj);

// $data = array("name"=>"MR.ROGERS", "phone_number"=>"999.111.1111", 'email' => "MR.ROGERS@test.com");
// $addNewDocs = $user->update_info($data);
// $this->assertEquals("SynapseException", get_class($addNewDocs) );
// }

// public function testGetAllInstitution(){
// // raises a 200 http status code
//     $clientObj = (object) [
//       'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//       'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//       'fingerprint' => '123456',
//       'ip_address' => '127.0.0.1'
//     ];
//     $client = new Client($clientObj);
//     $getInst=  $client->get_all_institutions();
    
//     $this->assertEquals(True, is_object($getInst));
// }

// public function testUpdateExistingDocs()
// {
// // http_status code 200
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $getuser = $client->get_user("5bfc547cbaabfc00b46ffd00");
// $data = array("name"=>"MR.ROGERS", "phone_number"=>"999.111.1111", 'email' => "MR.ROGERS@test.com");
// $addNewDocs = $getuser->update_info($data);
// $this->assertEquals(True, is_object($addNewDocs));

// // http_status code 400
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1'
// ];

// $client = new Client($clientObj);
// $getuser = $client->get_user("5bfc547cbaabfc00b46ffd00");
// $returnObj = (object) [
//   //'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'XSPUSERIP' => '127.0.0.1',
//   'XSPUSER' => '123456',
//   'id' => '5bfc547cbaabfc00b46ffd00',
//   'payload' => $getuser->payload,
//   'oauth' => $getuser->oauth,
//   'ContentType' => 'application/json'
// ];

// $user = new User($returnObj);
// $data = array("name"=>"MR.ROGERS", "phone_number"=>"999.111.1111", 'email' => "MR.ROGERS@test.com");
// $addNewDocs = $user->update_info($data);
// $this->assertEquals("SynapseException", get_class($addNewDocs) );
// }


// public function testDeleteExistingDocs(){
// // http_status code = 200
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $getuser = $client->get_user("5bfc547cbaabfc00b46ffd00");
// $deletedocsbody = array("id"=>'5bfc547cbaabfc00b46ffd00', 'permission_scope' => "DELETE_DOCUMENT");
// $addNewDocs = $getuser->update_info($deletedocsbody);
// $this->assertEquals(True, is_object($addNewDocs));

// // http_status code 401, omitted Authentication error
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $getuser = $client->get_user("5bfc547cbaabfc00b46ffd00");
// $returnObj = (object) [
//   'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//    'XSPUSERIP' => '127.0.0.1',
//    'XSPUSER' => '123456',
//    'id' => '5bfc547cbaabfc00b46ffd00',
//   'payload' => $returnObj->payload,
//   //'oauth' => $returnObj->oauth,
//   'ContentType' => 'application/json'
// ];

// $user = new User($returnObj);
// $deletedocsbody = array("id"=>'5bfc547cbaabfc00b46ffd00', 'permission_scope' => "DELETE_DOCUMENT");
// $delDocs = $user->update_info($deletedocsbody);
// $this->assertEquals("SynapseException", get_class($delDocs) );

// // http_status code 400
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $getuser = $client->get_user("5bfc547cbaabfc00b46ffd00");
// $returnObj = (object) [
//   //'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//    'XSPUSERIP' => '127.0.0.1',
//    'XSPUSER' => '123456',
//    'id' => '5bfc547cbaabfc00b46ffd00',
//   'payload' => $returnObj->payload,
//   'oauth' => $returnObj->oauth,
//   'ContentType' => 'application/json'
// ];

// $user = new User($returnObj);
// $deletedocsbody = array("id"=>'5bfc547cbaabfc00b46ffd00', 'permission_scope' => "DELETE_DOCUMENT");
// $delDocs = $user->update_info($deletedocsbody);
// $this->assertEquals("SynapseException", get_class($delDocs) );
// }

// public function testUpdateUser(){
// // http_status code 200
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1'
// ];

// $client = new Client($clientObj);
// $getuser = $client->get_user("5bfc547cbaabfc00b46ffd00");

// $data = array("name"=>"MR.ROGERS", "phone_number"=>"999.111.1111", 'email' => "MR.ROGERS@test.com");
// $addNewDocs = $getuser->update_info($data);
// $this->assertEquals(True, is_object($addNewDocs));

// // http_status code 401, ommite oauth
//       $clientObj = (object) [
//         'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//         'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//         'fingerprint' => '123456',
//         'ip_address' => '127.0.0.1'
//       ];
//       $client = new Client($clientObj);
//       $getuser = $client->get_user("5bfc547cbaabfc00b46ffd00");
//       $returnObj = (object) [
//         'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//          'XSPUSERIP' => '127.0.0.1',
//          'XSPUSER' => '123456',
//          'id' => '5bfc547cbaabfc00b46ffd00',
//         'payload' => $getuser->payload,
//       //  'oauth' => $getuser->oauth,
//         'ContentType' => 'application/json'
//       ];
//       $user = new User($returnObj);
//       $data = array("name"=>"MR.ROGERS", "phone_number"=>"999.111.1111", 'email' => "MR.ROGERS@test.com");
//       $addNewDocs = $user->update_info($data);
//       var_dump("add new docs failure", $addNewDocs);
//       $this->assertEquals("Authentication Error", $addNewDocs);

// // http_status code 400, ommitted clientid and client secret
// $clientObj = (object) [
//   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//   'fingerprint' => '123456',
//   'ip_address' => '127.0.0.1'
// ];
// $client = new Client($clientObj);
// $getuser = $client->get_user("5bfc547cbaabfc00b46ffd00");
// $returnObj = (object) [
//   //'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//    'XSPUSERIP' => '127.0.0.1',
//    'XSPUSER' => '123456',
//    'id' => '5bfc547cbaabfc00b46ffd00',
//   'payload' => $getuser->payload,
//   'oauth' => $getuser->oauth,
//   'ContentType' => 'application/json'
// ];
// $user = new User($returnObj);
// $data = array("name"=>"MR.ROGERS", "phone_number"=>"999.111.1111", 'email' => "MR.ROGERS@test.com");
// $addNewDocs = $user->update_info($data);
// $this->assertEquals("Bad request to API. Missing a field or an invalid field", $addNewDocs);
// }


}
?>
