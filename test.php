<?php
include 'client.php';
include 'Subscription.php';
use \Mockery as m;
use PHPUnit\Framework\TestCase;
//require_once ('PHPUnit/Framework/TestCase.php');



Class ClientTest extends TestCase
{

public function testGetUser()
{
//checking for no errors
    // $clientObj = (object) [
    //   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
    //   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
    //   'fingerprint' => '|123456',
    //   'ip_address' => '127.0.0.1'
    // ];
    // $client = new Client($clientObj);
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
    //   'ip_address' => '127.0.0.1'
    // ];
    // $client = new Client($clientObj);
    // $testObj = $client->getUser('5bfc547cbaabfc00b46ffd0');
    // $this->assertEquals('Cannot be found', $testObj);

//'Bad request to API. Missing a field or an invalid field';
    $clientObj = (object) [
      'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
      'fingerprint' => '|123456',
      'ip_address' => '127.0.0.1'
    ];
    $client = new Client($clientObj);
    $testObj = $client->getUser('5bfc547cbaabfc00b46ffd00');
    //$this->assertEquals("Bad request to API. Missing a field or an invalid field", $testObj);
   var_dump("SynapseException", $testObj);
}

public function testCreateUser()
{
//http_code = 200
    // $clientObj = (object) [
    //   'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
    //   'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
    //   'fingerprint' => '|123456',
    //   'ip_address' => '127.0.0.1'
    // ];
    // $logins_object = (object) [
    //   'email' => 'mr.rogers@synapsefi.com',
    //   'password' => 'mr.rogerslovessynapsefi',
    //   'scope' => 'READ_AND_WRITE'
    // ];
    // $legalnames_array = array();
    // $legalnames_array[] = 'Mr.rogers';
    // $phoneNumbers_array = array();
    // $phoneNumbers_array[] = '666.111.1111';
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
    // $this->assertEquals("Bad request to API. Missing a field or an invalid field", $testObj);
}

// public function testGetAllUsers(){
//     $clientObj = (object) [
//       'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//       'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//       'fingerprint' => '|123456',
//       'ip_address' => '127.0.0.1'
//     ];
//     $client = new Client($clientObj);
//     $allUsers = $client->getAllUsers();
//   }

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
  // var_dump($depositaccount);
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
//   $user = new User($returnObj);
//
// $testObj = $user->createDepositAccounts($deposit_account_object);
// $this->assertEquals("Bad request to API. Missing a field or an invalid field", $testObj);
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
// $this->assertEquals("Authentication Error", $testObj);

}

public function testGetNode()
{
//http_code= 200
//     $clientObj = (object) [
//       'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//       'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//       'fingerprint' => '|123456',
//       'ip_address' => '127.0.0.1'
//     ];
//     $client = new Client($clientObj);
//     $getuserobj =  $client->getUser('5bfc547cbaabfc00b46ffd00');
//
//     $returnObj = (object) [
//       'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//       'XSPUSERIP' => '127.0.0.1',
//       'XSPUSER' => '|123456',
//       'id' => '5bfc547cbaabfc00b46ffd00',
//       'payload' => $getuserobj->payload,
//       'oauth' => $getuserobj->oauth,
//       'ContentType' => 'application/json'
//     ];
//     $user = new User($returnObj);
//     $getNodeObj = $user->getNode('5bfc7ea3192dde00c2fd9189');
//
//     $this->assertEquals(True, is_string($getNodeObj->node_id));
//     $this->assertEquals(True, is_string($getNodeObj->user_id));
//     $this->assertEquals(True, is_string($getNodeObj->type));
//     $this->assertEquals(True, is_object($getNodeObj->body));
//
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
    //
    // $this->assertEquals('Cannot be found', $getNodeObj);
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
// $this->assertEquals('Bad request to API. Missing a field or an invalid field', $getNodeObj);
}

public function testCreateSubscription()
{
//   $clientObj = (object) [
//     'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//     'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//     'fingerprint' => '|123456',
//     'ip_address' => '127.0.0.1'
//   ];
//   $client = new Client($clientObj);
//
//   $subarray = array();
//   $subarray[] = "USERS|POST";
//   $subarray[] = "USER|PATCH";
//
//   $subarray[] = "NODES|POST";
//   $subarray[] = "NODE|PATCH";
//
//   $subarray[] = "TRANS|POST";
//   $subarray[] = "TRAN|PATCH";
//
//
//   $subscriptionOBJ = (object) [
//   "scope" => $subarray,
//   "url" => "https://requestb.in/zp216zzp"
//   ];
//
//   $payload = $client->createSubscription($subscriptionOBJ);
//   $newSubObj = new Subscription($payload->_id, $payload->url, $payload);
//   $this->assertEquals(True, is_string($newSubObj->id));
//   $this->assertEquals(True, is_string($newSubObj->url));
//   $this->assertEquals(True, is_object($newSubObj->body));
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
  // $this->assertEquals('Bad request to API. Missing a field or an invalid field', $payload);
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
// $payload = $client->getSubscription('5bfc8c1e74d505009543b084');
// $newSubObj = new Subscription($payload->_id, $payload->url, $payload);
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
// $this->assertEquals("Bad request to API. Missing a field or an invalid field", $payload);
 }

public function testGetPublicKey(){
// raises 200 status code
//   $clientObj = (object) [
//     'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//     'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//     'fingerprint' => '|123456',
//     'ip_address' => '127.0.0.1'
//   ];
//   $client = new Client($clientObj);
//   $scope = array();
//   $scope[] = 'USERS|GET';
//   $payload = $client->getPublicKey('YES', 'scope=USERS|GET');
//
//   var_dump("publickeypayload:", $payload);
//
//
//   $this->assertEquals(True, is_object($payload));\
// //raise http code 400 ommited client secret
//   $clientObj = (object) [
//     'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//     'fingerprint' => '|123456',
//     'ip_address' => '127.0.0.1'
//   ];
//   $client = new Client($clientObj);
//   $scope = array();
//   $scope[] = 'USERS|GET';
//   $payload = $client->getPublicKey('YES', 'scope=USERS|GET');
//
//
//   $this->assertEquals("Bad request to API. Missing a field or an invalid field", $payload);
}

public function testAddUserKYC()
{
//raises a 200 status code
//     $clientObj = (object) [
//       'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//       'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//       'fingerprint' => '|123456',
//       'ip_address' => '127.0.0.1'
//     ];
//     $client = new Client($clientObj);
//
//     $getuser = $client->getUser("5bfc547cbaabfc00b46ffd00");
//     $data = array("name"=>"MR.ROGERS", "phone_number"=>"999.111.1111", 'email' => "MR.ROGERS@test.com");
//     $addNewDocs = $getuser->addNewDocuments($data);
//
//     $this->assertEquals(True, is_object($getNodeObj->$addNewDocs));
//

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
// $this->assertEquals("Bad request to API. Missing a field or an invalid field", $addNewDocs);
}

public function testGetInstitution(){
//raises a 200 http status code
//     $clientObj = (object) [
//       'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//       'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//       'fingerprint' => '|123456',
//       'ip_address' => '127.0.0.1'
//     ];
//     $client = new Client($clientObj);
//     $getInst=  $client->getInstitution();
//
//     $this->assertEquals(True, is_object($getInst));
}

public function testUpdateExistingDocs()
{
//http_status code 200
//       $clientObj = (object) [
//         'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//         'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//         'fingerprint' => '|123456',
//         'ip_address' => '127.0.0.1'
//       ];
//
//       $client = new Client($clientObj);
//       $getuser = $client->getUser("5bfc547cbaabfc00b46ffd00");
//
//       $data = array("name"=>"MR.ROGERS", "phone_number"=>"999.111.1111", 'email' => "MR.ROGERS@test.com");
//       $addNewDocs = $getuser->updateUser($data);
//
//       var_dump("Update user docs:", $addNewDocs);
//       $this->assertEquals(True, is_object($addNewDocs));


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
      // $addNewDocs = $user->updateDocuments($data);
      //
      // $this->assertEquals("Bad request to API. Missing a field or an invalid field", $addNewDocs);
}

public function testDeleteExistingDocs(){
//http_status code = 200
//       $clientObj = (object) [
//         'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//         'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//         'fingerprint' => '|123456',
//         'ip_address' => '127.0.0.1'
//       ];
//
//       $client = new Client($clientObj);
//       $getuser = $client->getUser("5bfc547cbaabfc00b46ffd00");
//
//
//       $deletedocsbody = array("id"=>'5bfc547cbaabfc00b46ffd00', 'permission_scope' => "DELETE_DOCUMENT");
//       $addNewDocs = $getuser->updateDocuments($deletedocsbody);
//
//       var_dump("Delete user docs:", $addNewDocs);
//       $this->assertEquals(True, is_object($addNewDocs));

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
//   'oauth' => $returnObj->oauth,
//   'ContentType' => 'application/json'
// ];
//
// $user = new User($returnObj);
// $deletedocsbody = array("id"=>'5bfc547cbaabfc00b46ffd00', 'permission_scope' => "DELETE_DOCUMENT");
// $addNewDocs = $user->updateDocuments($deletedocsbody);
// $this->assertEquals("Authentication Error", $addNewDocs);

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
// $addNewDocs = $user->updateDocuments($deletedocsbody);
// $this->assertEquals("Bad request to API. Missing a field or an invalid field", $addNewDocs);
}

public function testUpdateUser(){
//http_status code 200
//       $clientObj = (object) [
//         'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
//         'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
//         'fingerprint' => '|123456',
//         'ip_address' => '127.0.0.1'
//       ];
//
//       $client = new Client($clientObj);
//       $getuser = $client->getUser("5bfc547cbaabfc00b46ffd00");
//
//       $data = array("name"=>"MR.ROGERS", "phone_number"=>"999.111.1111", 'email' => "MR.ROGERS@test.com");
//       $addNewDocs = $getuser->updateUser($data);
//
//
//       $this->assertEquals(True, is_object($addNewDocs));

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
