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


  function __construct($clientObj) {

    $this->$clientId = $clientObj->client_id;
    $this->$clientSecret = $clientObj->client_secret;
    $this->fingerPrint = $clientObj->fingerprint;
    $this->ipAddress = $clientObj->ip_address;
    $this->devMode;

    $this->$headersObj = (object) [
      'XSPGATEWAY' => $clientObj->client_id . '|' . $clientObj->client_secret,
      'XSPUSERIP' => $this->ipAddress,
      'XSPUSER' => $this->fingerPrint,
      'ContentType' => 'application/json'
    ];
  }

  function checkForErrors($http_code, $error_message, $error_code, $response){
    if ($http_code == '202'){
      throw new Exception("Accepted, but not final response");
    }
    if ($http_code == '400'){
      $synapseExcpetion = new SynapseException($http_code, $error_message, $error_code, $response);
      return $synapseExcpetion;
    }
    if ($http_code == '401'){
      throw new Exception("Authentication Error");
    }
    if ($http_code == '402'){
      throw new Exception("Request to the API failed");
    }
    if ($http_code == '404'){
      throw new Exception("Cannot be found");
    }
    if ($http_code == '409'){
      throw new Exception("Incorrect Values Supplied (eg. Insufficient balance, wrong MFA response, incorrect micro deposits, etc.)");
    }
    if ($http_code == '429'){
      throw new Exception("Too many requests hit the API too quickly.");
    }
    if ($http_code == '500'){
      throw new Exception("Internal Server Error");
    }
    if ($http_code == '503'){
      throw new Exception("The server is currently unable to handle the request due to a temporary overload or scheduled maintenance.");
    }
  }

  function createUser($logins_object, $phoneNumbers_array, $legalnames_array) {

    $newUser = createUserRequest($this->$headersObj, $logins_object, $phoneNumbers_array, $legalnames_array);

    try{
      $this->checkForErrors($newUser->http_code, $newUser->error);
    }
    catch(Exception $e){
      //echo "Message: " . $e->getMessage();
      return $e->getMessage();
    }

    $refreshtoken = $newUser->refresh_token;
    $userid = $newUser->_id;
    $ouathkey = getOauthUserRequests($this->$headersObj, $refreshtoken, $userid);

    //I think the headers are useful for the user to have so taht they can call the api without accessing the client's info
    //EXAMPLE: https://docs.synapsefi.com/docs/updating-existing-document
    $returnObj = (object) [
      'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
      'XSPUSERIP' => '127.0.0.1',
      'XSPUSER' => '|123456',
      'id' => $userid,
      'payload' => $newUser,
      'oauth' => $ouathkey,
      'ContentType' => 'application/json'
    ];
    $user = new User($returnObj);
    return $user;
  }

  function getUser(string $userid, $options=null) {

      $userObj = getUserRequest($this->$headersObj, $userid, $options);
      $returnobj = $this->checkForErrors($userObj->http_code, $userObj->error->en, $userObj->error_code, $userObj);

      $refreshtoken = $userObj->refresh_token;
      $oauthkey = getOauthUserRequests($this->$headersObj, $refreshtoken, $userid);

      $returnObj = (object) [
        'XSPGATEWAY' => $this->$headersObj->XSPGATEWAY,
        'XSPUSERIP' => $this->$headersObj->XSPUSERIP,
        'XSPUSER' => $this->$headersObj->XSPUSER,
        'id' => $userid,
        'payload' => $userObj,
        'oauth' => $oauthkey,
        'ContentType' => $this->$headersObj->ContentType
      ];
      $user = new User($returnObj);
      return $user;
  }

  //$query = null, $page = null, $per_page = null, $refreshtoken = null, $fulldehydrate=null
  function getAllUsers($options = null) {
      //$this->$headersObj, $query, $page, $per_page, $refreshtoken, $fulldehydrate
      $allUsers = getAllUserRequest($this->$headersObj, $options);
      $returnobj = $this->checkForErrors($allUsers->http_code, $allUsers->error->en, $allUsers->error_code, $allUsers);

      if (get_class($returnobj) == "SynapseException"){
      return $returnobj;
      }

      $numUsers = $allUsers->users_count;
      $listOfUsers = array();
      foreach ($allUsers->users as $obj) {
        $refreshtoken = $obj->refresh_token;
        $userid = $obj->_id;
        $ouathkey = getOauthUserRequests($this->$headersObj, $refreshtoken, $userid);

        $returnObj = (object) [
          'XSPGATEWAY' => $this->$headersObj->XSPGATEWAY,
        //  'XSPGATEWAY' =>'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW|client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
          //'XSPUSERIP' => '127.0.0.1'
          'XSPUSERIP' => $this->$headersObj->XSPUSERIP,
          //'XSPUSER' => '|123456',
          'XSPUSER' => $this->$headersObj->XSPUSER,
          'id' => $userid,
          'payload' => $obj,
          'oauth' => $ouathkey,
          'ContentType' => 'application/json'
        ];
        $user = new User($returnObj);
        $listOfUsers[] = $user;
      }
      $allusersobj = (object)[
        'userscount' => $numUsers,
        'list' =>$listOfUsers
      ];
      $users = new Users($allusersobj);
      return $users;

  }



  function getAllPlatformTransactions($options = null){

      $allClientTransactions = getAllClientTransactionsRequest($this->$headersObj, $options);
      //var_dump($allClientTransactions);
      $returnobj = $this->checkForErrors($allClientTransactions->http_code, $allClientTransactions->error->en, $allClientTransactions->error_code, $allClientTransactions);

      if (get_class($returnobj) == "SynapseException"){
      return $returnobj;
      }
      //var_dump("all platform trans", $allClientTransactions);
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
       $userTransactions = getAllUserTransactionsRequests($this->$headersObj, $oauthkey, $userid, $options);
       return $userTransactions;
  }

  function getAllPlatformNodes(){
    $allnodesobj = getAllPlatformNodesRequests($this->$headersObj);
    $returnobj = $this->checkForErrors($allnodesobj->http_code, $allnodesobj->error->en, $allnodesobj->error_code, $allnodesobj);

    if (get_class($returnobj) == "SynapseException"){
    return $returnobj;
    }
    $node_count = $allnodesobj->node_count;
    $listOfNodes = array();
    foreach ($allnodesobj->nodes as $obj) {
        $nodeid= $obj->_id;
        $userid= $obj->user_id;
        $type = $obj->type;
        $payload = $obj;

        $node = new Node($payload,$userid, $nodeid, $type);
        $listOfNodes[] = $node;
    }
    $allnodes = new Nodes($node_count, $listOfNodes);
    return $allnodes;

  }//function get all platform nodes

  function getInstitution(){
    $allnodesobj = getInstitutionRequests($this->$headersObj);
    try{
      $this->checkForErrors($allnodesobj->http_code, $allnodesobj->error);
    }
    catch(Exception $e){
      //echo "Message: " . $e->getMessage();
      return $e->getMessage();
    }
    return $allnodesobj;
  }

  function getAllSubscriptions(){
    $allSubscriptions = getAllSubscriptionRequests($this->$headersObj);
    $returnobj = $this->checkForErrors($allSubscriptions->http_code, $allSubscriptions->error->en, $allSubscriptions->error_code, $allSubscriptions);
    if (get_class($returnobj) == "SynapseException"){
    return $returnobj;
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
    $subscriptionRequest = getSubscriptionRequest($this->$headersObj, $subscriptionID);
    try{
      $this->checkForErrors($subscriptionRequest->http_code, $subscriptionRequest->error);
    }
    catch(Exception $e){
      return $e->getMessage();
    }
    return $subscriptionRequest;
  }

  function createSubscription($subscriptionOBJ){
    $newsubscriptionOBJ = createSubscriptionRequest($this->$headersObj, $subscriptionOBJ);

    try{
      $this->checkForErrors($newsubscriptionOBJ->http_code, $userObj->error);
    }
    catch(Exception $e){
      //echo "Message: " . $e->getMessage();
      return $e->getMessage();
    }
    return $newsubscriptionOBJ;
  }

  function updateSubscription($updatesubscriptionOBJ){
    $subscriptionID = '5beb7fa32e39402a3a93e6c9';
    $updatedSubscription = updateSubscriptionRequest($this->$headersObj, $updatesubscriptionOBJ, $subscriptionID);
    return $updatedSubscription;
  }

  function getPublicKey($issue_public_key, $scope){
    $body = getPublicKeyRequests($this->$headersObj, $issue_public_key, $scope);
    try{
      $this->checkForErrors($body->http_code, $body->error);
    }
    catch(Exception $e){
      //echo "Message: " . $e->getMessage();
      return $e->getMessage();
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
