 <?php
include 'HTTPHandler.php';
include 'User.php';
include 'Users.php';
include 'Nodes.php';
include 'Subscriptions.php';
include 'Transactions.php';
include 'SynapseException.php';

class Client
{

  public $headersObj;
  public $clientId;
  public $clientSecret;
  public $fingerPrint;
  public $ipAddress;
  public $full_dehydrate;


  function __construct($clientObj) {

    $this->clientId = $clientObj->client_id;
    $this->clientSecret = $clientObj->client_secret;
    $this->fingerPrint = $clientObj->fingerprint;
    $this->ipAddress = $clientObj->ip_address;
    $this->full_dehydrate = $clientObj->full_dehydrate;

    $this->headersObj = (object) [
      'XSPGATEWAY' => $clientObj->client_id . '|' . $clientObj->client_secret,
      'XSPUSERIP' => $this->ipAddress,
      'XSPUSER' => $this->fingerPrint,
      'ContentType' => 'application/json'
    ];
  }

  function getUserHTTP($userid) {
      //$url =  "https://uat-api.synapsefi.com/v3.1/users/" . $userid;
      $userObj = getUserRequest($this->headersObj, $userid, $options);
      try{
        $this->checkForErrors($userObj->http_code, $userObj->error->en, $userObj->error_code, $userObj);
      }
      catch(SynapseException $e){
        return $e;
      }

      $refreshtoken = $userObj->refresh_token;
      $oauthkey = getOauthUserRequests($this->headersObj, $refreshtoken, $userid);

      $returnObj = (object) [
        'XSPGATEWAY' => $this->headersObj->XSPGATEWAY,
        'XSPUSERIP' => $this->headersObj->XSPUSERIP,
        'XSPUSER' => $this->headersObj->XSPUSER,
        'id' => $userid,
        'payload' => $userObj,
        'oauth' => $oauthkey,
        'ContentType' => $this->headersObj->ContentType
      ];
      $user = new User($returnObj);
      return $user;
  }


  function checkForErrors($http_code, $error_message, $error_code, $response){

    if ($http_code == '202'){
      throw new SynapseException($http_code, $error_message, $error_code, $response);
    }
    if ($http_code == '400'){
      throw new SynapseException($http_code, $error_message, $error_code, $response);
    }
    if ($http_code == '401'){
      throw new SynapseException($http_code, $error_message, $error_code, $response);
    }
    if ($http_code == '402'){
      throw new SynapseException($http_code, $error_message, $error_code, $response);
    }
    if ($http_code == '404'){
      throw new SynapseException($http_code, $error_message, $error_code, $response);
    }
    if ($http_code == '409'){
      throw new SynapseException($http_code, $error_message, $error_code, $response);
    }
    if ($http_code == '429'){
      throw new SynapseException($http_code, $error_message, $error_code, $response);
    }
    if ($http_code == '500'){
      throw new SynapseException($http_code, $error_message, $error_code, $response);
    }
    if ($http_code == '503'){
      throw new SynapseException($http_code, $error_message, $error_code, $response);
    }
  }

  function createUser($logins_object, $phoneNumbers_array, $legalnames_array) {
    $newUser = createUserRequest($this->headersObj, $logins_object, $phoneNumbers_array, $legalnames_array);
    $errormessage = $newUser->error->en;
    $errorcode = $newUser->error_code;
    $httpcode= $newUser->http_code;

    try{
      $this->checkForErrors($httpcode, $errormessage, $errorcode, $newUser);
    }
    catch(SynapseException $e){
      return $e;
    }

    $refreshtoken = $newUser->refresh_token;
    $userid = $newUser->_id;
    $ouathkey = getOauthUserRequests($this->headersObj, $refreshtoken, $userid);

    //I think the headers are useful for the user to have so taht they can call the api without accessing the client's info
    //EXAMPLE: https://docs.synapsefi.com/docs/updating-existing-document
    $returnObj = (object) [
      'XSPGATEWAY' => $this->headersObj->XSPGATEWAY,
      'XSPUSERIP' => $this->headersObj->XSPUSERIP,
      'XSPUSER' => $this->headersObj->XSPUSER,
      'id' => $userid,
      'payload' => $newUser,
      'oauth' => $ouathkey,
      'ContentType' => 'application/json'
    ];
    $user = new User($returnObj);
    return $user;
  }

  function getUser(string $userid, $options=null) {

      $userObj = getUserRequest($this->headersObj, $userid, $options);
      $errormessage = $userObj->error->en;
      $errorcode = $userObj->error_code;
      $httpcode= $userObj->http_code;

      try{
        $this->checkForErrors($httpcode, $errormessage, $errorcode, $userObj);
      }
      catch(SynapseException $e){
        return $e;
      }

      $refreshtoken = $userObj->refresh_token;
      $oauthkey = getOauthUserRequests($this->headersObj, $refreshtoken, $userid);

      $returnObj = (object) [
        'XSPGATEWAY' => $this->headersObj->XSPGATEWAY,
        'XSPUSERIP' => $this->headersObj->XSPUSERIP,
        'XSPUSER' => $this->headersObj->XSPUSER,
        'id' => $userid,
        'payload' => $userObj,
        'oauth' => $oauthkey,
        'ContentType' => $this->headersObj->ContentType
      ];
      $user = new User($returnObj);
      return $user;
  }

  function getAllUsers($options = null) {

      $allUsers = getAllUserRequest($this->headersObj, $options);
      $errormessage = $allUsers->error->en;
      $errorcode = $allUsers->error_code;
      $httpcode= $allUsers->http_code;

      try{
        $this->checkForErrors($httpcode, $errormessage, $errorcode, $allUsers);
      }
      catch(SynapseException $e){
        return $e;
      }

      $numUsers = $allUsers->users_count;
      $limit = $allUsers->limit;
      $page = $allUsers->page;
      $page_count = $allUsers->page_count;

      $listOfUsers = array();
      foreach ($allUsers->users as $obj) {
        $refreshtoken = $obj->refresh_token;
        $userid = $obj->_id;
        $ouathkey = getOauthUserRequests($this->headersObj, $refreshtoken, $userid);

        $returnObj = (object) [
          'XSPGATEWAY' => $this->headersObj->XSPGATEWAY,
          'XSPUSERIP' => $this->headersObj->XSPUSERIP,
          'XSPUSER' => $this->headersObj->XSPUSER,
          'id' => $userid,
          'payload' => $obj,
          'oauth' => $ouathkey,
          'ContentType' => 'application/json'
        ];
        $user = new User($returnObj);
        $listOfUsers[] = $user;
      }

      $users = new Users($listOfUsers, $numUsers, $page, $page_count, $limit);
      return $users;
  }

  function getAllPlatformTransactions($options = null){

      $allClientTransactions = getAllClientTransactionsRequest($this->headersObj, $options);

      $errormessage = $allClientTransactions->error->en;
      $errorcode = $allClientTransactions->error_code;
      $httpcode= $allClientTransactions->http_code;

      try{
        $this->checkForErrors($httpcode, $errormessage, $errorcode, $allClientTransactions);
      }
      catch(SynapseException $e){
        return $e;
      }

      $numTrans = $allClientTransactions->trans_count;
      $limit = $allClientTransactions->limit;
      $page_count = $allClientTransactions->page_count;
      $page = $allClientTransactions->page;

     $listOfTrans = array();
     foreach ($allClientTransactions->trans as $obj) {
       $trans = new Transaction($obj_id, $obj);
       $listOfTrans[] = $trans;
     }
     $trans = new Transactions($numTrans, $listOfTrans, $limit, $page_count, $page);
     return $trans;
  }

  // this CODE IS NOT COMPLETE IT STILL NEEDS TO HANDLE OPTIONAL PARAMS like pagination
  function getAllUserTransactions($userobj){

       $oauthkey = $userobj->oauth_key;
       $userid = $userobj->_id;
       $userTransactions = getAllUserTransactionsRequests($this->headersObj, $oauthkey, $userid, $options);
       return $userTransactions;
  }

  function getAllPlatformNodes(){
    $allnodesobj = getAllPlatformNodesRequests($this->headersObj);
    $errormessage = $allnodesobj->error->en;
    $errorcode = $allnodesobj->error_code;
    $httpcode= $allnodesobj->http_code;
    try{
      $this->checkForErrors($httpcode, $errormessage, $errorcode, $allnodesobj);
    }
    catch(SynapseException $e){
      return $e;
    }
    $node_count = $allnodesobj->node_count;
    $page = $allnodesobj->page;
    $page_count = $allnodesobj->page_count;
    $limit = $allnodesobj->limit;
    // var_dump("this is the nodecount", $node_count);
    // var_dump("this is the page", $page);
    // var_dump("this is the pagecount", $page_count);
    // var_dump("this is the limit", $limit);
    $listOfNodes = array();
    foreach ($allnodesobj->nodes as $obj) {
        $nodeid= $obj->_id;
        $userid= $obj->user_id;
        $type = $obj->type;
        $payload = $obj;
        $node = new Node($payload,$userid, $nodeid, $type);
        $listOfNodes[] = $node;
    }
    $allnodes = new Nodes($node_count, $listOfNodes, $page, $page_count, $limit);
    return $allnodes;
  }//function get all platform nodes

  function getInstitution(){
    $allInstit = getInstitutionRequests($this->$headersObj);
    $errormessage = $allInstit->error->en;
    $errorcode = $allInstit->error_code;
    $httpcode= $allInstit->http_code;

    try{
      $this->checkForErrors($httpcode, $errormessage, $errorcode, $allInstit);
    }
    catch(SynapseException $e){
      return $e;
    }
    return $allInstit;
  }

  function getAllSubscriptions(){
    $allSubscriptions = getAllSubscriptionRequests($this->headersObj);
    $errormessage = $allSubscriptions->error->en;
    $errorcode = $allSubscriptions->error_code;
    $httpcode= $allSubscriptions->http_code;
    try{
      $this->checkForErrors($httpcode, $errormessage, $errorcode, $allSubscriptions);
    }
    catch(SynapseException $e){
      return $e;
    }
    $numSubs = $allSubscriptions->subscriptions_count;
    $page = $allSubscriptions->page;
    $limit = $allSubscriptions->limit;
    $page_count = $allSubscriptions->page_count;

   $listOfSubs = array();
   foreach ($allSubscriptions->subscriptions as $obj) {
    $sub = new Subscription($obj->_id, $obj->url, $obj);
    $listOfSubs[] = $sub;
   }
    $subs = new Subscriptions($listOfSubs, $numSubs, $page, $limit, $page_count);
    return $subs;
  }

  function getSubscription($subscriptionID){
    $subscriptionRequest = getSubscriptionRequest($this->headersObj, $subscriptionID);

    $errormessage = $subscriptionRequest->error->en;
    $errorcode = $subscriptionRequest->error_code;
    $httpcode= $subscriptionRequest->http_code;

    try{
      $this->checkForErrors($httpcode, $errormessage, $errorcode, $subscriptionRequest);
    }
    catch(SynapseException $e){
      return $e;
    }

    $getSubObj = new Subscription($subscriptionRequest->_id, $subscriptionRequest->url, $subscriptionRequest);
    return $getSubObj;
  }

  function createSubscription($subscriptionOBJ){
    $newsubscriptionOBJ = createSubscriptionRequest($this->headersObj, $subscriptionOBJ);
    $errormessage = $newsubscriptionOBJ->error->en;
    $errorcode = $newsubscriptionOBJ->error_code;
    $httpcode= $newsubscriptionOBJ->http_code;

    try{
      $this->checkForErrors($httpcode, $errormessage, $errorcode, $newsubscriptionOBJ);
    }
    catch(SynapseException $e){
      return $e;
    }

    $newSubObj = new Subscription($newsubscriptionOBJ->_id, $newsubscriptionOBJ->url, $newsubscriptionOBJ);
    return $newSubObj;
  }

  function updateSubscription($updatesubscriptionOBJ){
    $subscriptionID = '5beb7fa32e39402a3a93e6c9';
    $updatedSubscription = updateSubscriptionRequest($this->$headersObj, $updatesubscriptionOBJ, $subscriptionID);

    $errormessage = $updatedSubscription->error->en;
    $errorcode = $updatedSubscription->error_code;
    $httpcode= $updatedSubscription->http_code;

    try{
      $this->checkForErrors($httpcode, $errormessage, $errorcode, $updatedSubscription);
    }
    catch(SynapseException $e){
      return $e;
    }

    return $updatedSubscription;
  }

  function getPublicKey($issue_public_key, $scope){
    $body = getPublicKeyRequests($this->headersObj, $issue_public_key, $scope);

    $errormessage = $body->error->en;
    $errorcode = $body->error_code;
    $httpcode= $body->http_code;

    try{
      $this->checkForErrors($httpcode, $errormessage, $errorcode, $body);
    }
    catch(SynapseException $e){
      return $e;
    }

    return $body;
  }

} // class client

//THIS IS WHAT THE DEVELOPER DOES
//KEEP consisten
$clientObj = (object) [
  'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
  'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
  'fingerprint' => '|123456',
  'ip_address' => '127.0.0.1'
];

$logins_object = (object) [
  'email' => 'billgates@synapsefi.com',
  'password' => 'billgateslovessynapsefi',
  'scope' => 'READ_AND_WRITE'
];
$legalnames_array = array();
$legalnames_array[] = 'Richard Gates';
$phoneNumbers_array = array();
$phoneNumbers_array[] = '206.111.1111';


$info = (object) [
  'nickname' => 'My Checking'
];
$deposit_account_object = (object) [
  'type' => 'DEPOSIT-US',
  'info' => $info
];

$virtualObj = (object)[
    "document_value" => "2222",
    "document_type" => "SSN"
];
$virtualArray = array($virtualObj);

$physicalObj = (object)[
  "document_value" => "data:image/gif;base64,SUQs==",
  "document_type" => "GOVT_ID"
];
$physicalArray = array($physicalObj);

$socialObj = (object)[
    "document_value" => "https://www.facebook.com/valid",
    "document_type" => "FACEBOOK"
];
$socialArray = array( $socialObj);


$data = array("name"=>"sundar pichai", "phone_number"=>"901.111.1111", 'email' => "sundar@test.com");

$updatedocsbody = array("id"=>'5bef6f1cb68b62009a5e0bb6', 'email' => "billgatesnewemail@synapsefi.com");
$deletedocsbody = array("id"=>'5beb22bc321f482c41aca2d6', 'permission_scope' => "DELETE_DOCUMENT");
$deleteuserbody = (object) [
  'permission' => "MAKE-IT-GO-AWAY"
];

$loginobj = (object) [
  'email' => "billgatesMOSTESTupdatedemail@synapsefi.com"
];
$updateuserbody = (object) [
  'login' => $loginobj
];
$updateuserbody = (object) [
  'update' => $updateuserbody
];

//
//
$client = new Client($clientObj);
//  //print_r($client);
 //$getuser = $client->getUser('5bfc543fc256c300ad7bbc4e');

 $client->getAllPlatformNodes();
//
// $return = $getuser->addNewDocuments($data);
// var_dump("added new docs", $return);

 //$getuser->updateDocuments($deletedocsbody);
//$getuser->updateUser($deleteuserbody);
 //$getuser->updateUser($updateuserbody);





?>
