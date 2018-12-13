 <?php
include 'HTTPHandler.php';
include 'HttpClient.php';
include 'User.php';
include 'Users.php';
include 'Nodes.php';
include 'Subscriptions.php';
include 'Subscription.php';
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
  public $base_url;
  public $devmode;
  public $handle202;
  public $printToConsole;


  function __construct($clientObj) {

    $this->clientId = $clientObj->client_id;
    $this->clientSecret = $clientObj->client_secret;
    $this->fingerPrint = $clientObj->fingerprint;
    $this->ipAddress = $clientObj->ip_address;
    $this->full_dehydrate = $clientObj->full_dehydrate;
    $this->devmode = $clientObj->devmode;
    $this->handle202 = $clientObj->handle202;
    $this->printToConsole = $clientObj->printToConsole;

    if($this->devmode == True){
      $this->base_url = 'https://uat-api.synapsefi.com/v3.1/' ;
    }
    else{
      $this->base_url = 'https://api.synapsefi.com/v3.1/' ;
    }
    if (isset($options['printToConsole'])) {
      $this->printToConsole = $options['printToConsole'];
    }
    $this->headersObj = (object) [
      'XSPGATEWAY' => $clientObj->client_id . '|' . $clientObj->client_secret,
      'XSPUSERIP' => $this->ipAddress,
      'XSPUSER' => $this->fingerPrint,
      'ContentType' => 'application/json',
      'base_url' => $this->base_url
    ];

    $httpclient = new HttpClient($this->headersObj);
  }


  function refresh($userid){
    $http = new HttpClient();
    $url = $this->base_url . "users/" . $userid;

    $user = $http->get($this->headersObj, $url, $userid);
    $refreshtoken = $user->refresh_token;
    $refreshobj = (object)[
      "refresh_token" => $refreshtoken
    ];
    $ouathurl = $this->base_url . "oauth/" . $userid;
    $oauthobj = $http->post($this->headersObj, $ouathurl, $refreshobj);
    $ouathkey = $oauthobj->oauth_key;
    return $ouathkey;
  }


  function getUser($userid, $full_dehydrate= null) {
      $url = $this->base_url . "users/" . $userid;
      if(isset($full_dehydrate)){
          $url = $this->base_url . "users/" . $userid . '?full_dehydrate=' . $full_dehydrate;
        }

      $http = new HttpClient();
      $userObj = $http->get($this->headersObj, $url);
      try{
        $this->checkForErrors($userObj->http_code, $userObj->error->en, $userObj->error_code, $userObj);
      }
      catch(SynapseException $e){
        return $e;
      }
      $refreshtoken = $userObj->refresh_token;

      $oauthkey = $this->refresh($userid);
      $returnObj = (object) [
        'XSPGATEWAY' => $this->headersObj->XSPGATEWAY,
        'XSPUSERIP' => $this->headersObj->XSPUSERIP,
        'XSPUSER' => $this->headersObj->XSPUSER,
        'base_url' => $this->headersObj->base_url,
        'id' => $userid,
        'payload' => $userObj,
        'oauth' => $oauthkey,
        'ContentType' => $this->headersObj->ContentType,
        'fingerprint' => $this->fingerPrint,
        'handle202' =>$this->handle202,
        'printToConsole' => $this->printToConsole
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

  function createUser($body) {
    //$newUser = createUserRequest($this->headersObj, $logins_object, $phoneNumbers_array, $legalnames_array);
    $url = $this->base_url . "users";
    $http = new HttpClient();

    $newUser = $http->post($this->headersObj, $url, $body);

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
    //$ouathkey = getOauthUserRequests($this->headersObj, $refreshtoken, $userid);
    $ouathkey = $this->refresh($userid);
    $returnObj = (object) [
      'XSPGATEWAY' => $this->headersObj->XSPGATEWAY,
      'XSPUSERIP' => $this->headersObj->XSPUSERIP,
      'XSPUSER' => $this->headersObj->XSPUSER,
      'base_url' => $this->headersObj->base_url,
      'id' => $userid,
      'payload' => $newUser,
      'oauth' => $ouathkey,
      'ContentType' => 'application/json',
      'fingerprint' => $this->fingerPrint,
      'handle202' =>$this->handle202,
      'printToConsole' => $this->printToConsole
    ];
    $user = new User($returnObj);
    return $user;
  }

  function getUsers($query=null, $page=null, $per_page=null, $show_refresh=null) {
    $url = $this->base_url . "users";

    if($query){
				$path = $path . '?query=' . $query;
				if($page){
					$path = $path . '&amp;page=' . $page;
				}
				if($per_page){
					$path = $path . '&amp;per_page=' . $per_page;
				}
        if($show_refresh){
					$path = $path . '&amp;show_refresh_tokens=' . $show_refresh;
				}
			}elseif($page){
				$path = $path . '?page=' . $page;
				if($per_page){
					$path = $path . '&amp;per_page=' . $per_page;
				}
        if($show_refresh_tokens){
					$path = $path . '&amp;show_refresh_tokens=' . $show_refresh;
				}
			}elseif($per_page){
        $path = $path . '?per_page=' . $per_page;
        if($show_refresh_tokens){
					$path = $path . '&amp;show_refresh_tokens=' . $show_refresh;
				}
			}elseif($show_refresh){
        $path = $path . '?show_refresh_tokens='. $show_refresh;
      }

    $url = $url . $path;
    var_dump("this is the url", $url);
    $http = new HttpClient();
    $allUsers = $http->get($this->headersObj, $url);
    try{
      $this->checkForErrors($allUsers->http_code, $allUsers->error->en, $allUsers->error_code, $allUsers);
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
        //$ouathkey = getOauthUserRequests($this->headersObj, $refreshtoken, $userid);
        $ouathkey = $this->refresh($userid);
        $returnObj = (object) [
          'XSPGATEWAY' => $this->headersObj->XSPGATEWAY,
          'XSPUSERIP' => $this->headersObj->XSPUSERIP,
          'XSPUSER' => $this->headersObj->XSPUSER,
          'id' => $userid,
          'payload' => $obj,
          'oauth' => $ouathkey,
          'ContentType' => 'application/json',
          'fingerprint' => $this->fingerPrint,
          'handle202' =>$this->handle202,
          'printToConsole' => $this->printToConsole
        ];
        $user = new User($returnObj);
        $listOfUsers[] = $user;
      }
      $users = new Users($listOfUsers, $numUsers, $page, $page_count, $limit);
      return $users;
  }

  function getAllPlatformTransactions($page=null, $per_page=null){

    $url = $this->base_url . 'trans';
    if($page){
        $path = $path . '?page=' . $page;
        if($per_page){
          $path = $path . '&per_page=' . $per_page;
        }
      }elseif($per_page){
        $path = $path . '?per_page=' . $per_page;
      }
     $url = $url . $path;
     var_dump("url", $url);
     $http = new HttpClient();
     $this->headersObj->XSPUSER = $this->oauth . $this->fingerprint;
     $allClientTransactions = $http->get($this->headersObj, $url);
      //$allClientTransactions = getAllClientTransactionsRequest($this->headersObj, $options);
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

  function getSubscriptions($page = null, $per_page = null){
    $url = $this->base_url . 'subscriptions';
    if($page){
      $path = $path . '?page=' . $page;
      if($per_page){
        $path = $path . '&per_page=' . $per_page;
      }
    }elseif($per_page){
      $path = $path . '?per_page=' . $per_page;
    }
    $url = $url . $path;
    var_dump("subs url", $url);
    $http = new HttpClient();
    // $allSubscriptions = getAllSubscriptionRequests($this->headersObj);
    $allSubscriptions = $http->get($this->headersObj, $url);

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

  //no need for the client obj in response
  function getPublicKey($issue_public_key, $scope){

    $body = getPublicKeyRequests($this->headersObj, $issue_public_key, $scope);
    var_dump("the body", $body);
    $errormessage = $body->error->en;
    $errorcode = $body->error_code;
    $httpcode= $body->http_code;

    try{
      $this->checkForErrors($httpcode, $errormessage, $errorcode, $body);
    }
    catch(SynapseException $e){
      return $e;
    }
    return $body->public_key_obj;
  }

  function locateATMS($zip = null, $lat = null, $lon = null, $radius = null, $page = null, $per_page = null){
    $url = $this->base_url . 'nodes/atms';
    if($zip){
        $path = $path . '?zip=' . $zip;
        if($lat){
          $path = $path . '&lat=' . $lat;
        }
        if($lon){
          $path = $path . '&lon=' . $lon;
        }
        if($radius){
          $path = $path . '&radius=' . $radius;
        }
        if($page){
          $path = $path . '&page=' . $page;
        }
        if($per_page){
          $path = $path . '&per_page=' . $per_page;
        }
      }elseif($lat){
        $path = $path . '?lat=' . $lat;
        if($lon){
          $path = $path . '&lon=' . $lon;
        }
        if($radius){
          $path = $path . '&radius=' . $radius;
        }
        if($page){
          $path = $path . '&page=' . $page;
        }
        if($per_page){
          $path = $path . '&per_page=' . $per_page;
        }
      }elseif($lon){
        $path = $path . '?lon=' . $lon;
        if($radius){
          $path = $path . '&radius=' . $radius;
        }
        if($page){
          $path = $path . '&page=' . $page;
        }
        if($per_page){
          $path = $path . '&per_page=' . $per_page;
        }
      }elseif($radius){
          $path = $path . '?radius=' . $radius;
          if($page){
            $path = $path . '&page=' . $page;
          }
          if($per_page){
            $path = $path . '&per_page=' . $per_page;
          }
      }elseif($page){
          $path = $path . '?page=' . $page;
          if($per_page){
            $path = $path . '&per_page=' . $per_page;
          }
      }elseif($per_page){
          $path = $path . '?per_page=' . $per_page;
      }
    $url = $url . $path;
    var_dump("locate atm url", $url);

    $http = new HttpClient();
    $this->headersObj->XSPUSER = $this->oauth . $this->fingerprint;
    $atm = $http->get($this->headersObj, $url);
    while (is_string($atm)){
      $this->oauth = $this->refresh();
      $this->headersObj->XSPUSER = $this->oauth . $this->fingerprint;
      $atm = $http->get($this->headersObj, $url);
    }
    $errormessage = $atm->error->en;
    $errorcode = $atm->error_code;
    $httpcode= $atm->http_code;
    try{
      $this->checkForErrors($httpcode, $errormessage, $errorcode, $atm);
    }
    catch(SynapseException $e){
      return $e;
    }
    return $atm;
  }

  function getCryptoQuotes(){

    $url = $this->base_url . 'nodes/crypto-quotes';
    $http = new HttpClient();
    $this->headersObj->XPUSER = $this->oauth . $this->fingerprint;
    $cyrptoquotes = $http->get($this->headersObj, $url);
    while (is_string($cyrptoquotes)){
      $this->oauth = $this->refresh();
      $this->headersObj->XSPUSER = $this->oauth . $this->fingerprint;
      $cyrptoquotes = $http->get($this->headersObj, $url);
    }
    $errormessage = $cyrptoquotes->error->en;
    $errorcode = $cyrptoquotes->error_code;
    $httpcode= $cyrptoquotes->http_code;
    try{
      $this->checkForErrors($httpcode, $errormessage, $errorcode, $cyrptoquotes);
    }
    catch(SynapseException $e){
      return $e;
    }
    return $cyrptoquotes;
  }

  function getCryptoMarketData($limit, $currency){

    $url = $this->base_url . 'nodes/crypto-market-watch';
    if($limit){
        $path = $path . '?limit=' . $limit;
        if($currency){
          $path = $path . '&currency=' . $currency;
        }
      }elseif($currency){
        $path = $path . '?currency=' . $currency;
      }

    $url = $url . $path;
    var_dump("cryptomarket url", $url);

    $http = new HttpClient();
    $this->headersObj->XPUSER = $this->oauth . $this->fingerprint;
    $cryptomarket = $http->get($this->headersObj, $url);
    while (is_string($cryptomarket)){
      $this->oauth = $this->refresh();
      $this->headersObj->XSPUSER = $this->oauth . $this->fingerprint;
      $cryptomarket = $http->get($this->headersObj, $url);
    }
    $errormessage = $cryptomarket->error->en;
    $errorcode = $cryptomarket->error_code;
    $httpcode= $cryptomarket->http_code;
    try{
      $this->checkForErrors($httpcode, $errormessage, $errorcode, $cryptomarket);
    }
    catch(SynapseException $e){
      return $e;
    }
    return $cryptomarket;
  }



} // class client

//THIS IS WHAT THE DEVELOPER DOES
//KEEP consisten
$clientObj = (object) [
  'client_id' => 'client_id_jTiLPkUSeBmqhJy8bxDzsCatdv2A0G9VfpZw1YNW',
  'client_secret' => 'client_secret_OsJtbPR3SFYjy6wqEhNWX0H2molTdDQfK8ka9Cip',
  'fingerprint' => '|123456',
  'ip_address' => '127.0.0.1',
  'devmode' => True,
  'printToConsole' => True,
  'handle202' => False
];

$logins_object = (object) [
  'email' => 'CharlieMurphy@synapsefi.com',
  'password' => 'CharlieMurphylovessynapsefi',
  'scope' => 'READ_AND_WRITE'
];
$legalnames_array = array();
$legalnames_array[] = 'CharlieMurphy';
$phoneNumbers_array = array();
$phoneNumbers_array[] = '333.111.1111';


$logins_array = array();
$logins_array[] = $logins_object;

$data = array("logins"=>$logins_array, "phone_numbers"=>$phoneNumbers_array, "legal_names" => $legalnames_array);

// $info = (object) [
//   'nickname' => 'My Checking'
// ];
// $deposit_account_object = (object) [
//   'type' => 'DEPOSIT-US',
//   'info' => $info
// ];

$client = new Client($clientObj);

$newdocbody = (object)[
  "email"=>"mrT@test.com",
  "phone_number"=>"901.111.1111",
  "ip"=>"::1",
  "name"=>"Mr.T",
  "alias"=>"Mr.Talias",
  "entity_type"=>"M",
  "entity_scope"=>"Arts & Entertainment",
  "day"=>'2',
  "month"=>'5',
  "year"=>'1989'
];

//$user = $client->getUserHTTP('5c0199fe3c4e280a7d7c2a31', $param);
// $newDocuments = $user->addUserKYC($newdocbody);
// var_dump("documents added:", $newDocuments);



//test this id an expired ouath later: time-stamp:12:22pm
//oauth_Jeq4vk8bY5MsVIN2crmu3901LoKSRGHpyziaAD6P
//5beb6bcd321f481ae7ac868f
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

$docs = (object)
[
    "virtual_docs" => $virtualArray,
    "physical_docs" => $physicalArray,
    "social_docs" => $socialArray
];


$finaldocs = array('documents' => $docs);

$to = (object)[
  "type" => "ACH-US",
  "id" =>'5c05ae9fce316700ab2a571f'
];

$amount = (object)[
  "amount" => 20.1,
  "currency" => "USD"
];
$extra = (object)[
  "ip" => "127.0.0.1"
];

$transbody = (object)[
  "to" => $to,
  "amount" => $amount,
  "extra" => $extra
];
$subnetobj = (object) [
  "nickname" => "Test AC/RT"
];

$scopearray = array();
$scopearray[] = "OAUTH|POST";
//'OAUTH|POST,USERS|POST,USERS|GET,USER|GET,USER|PATCH,SUBSCRIPTIONS|GET,SUBSCRIPTIONS|POST,SUBSCRIPTION|GET,SUBSCRIPTION|PATCH,CLIENT|REPORTS,CLIENT|CONTROLS');
// $pkey = $client->getPublicKey('YES', 'USERS|GET');
//$ust = $user->getAllNodeStatements('5c05b55f36870400bfe2c10e',null,1);
//var_dump("pkey", $pkey);
$zip = 94114;
$lat = null;
$lon = null;
$radius = 5;
$page = 1;
$per_page = 1;

//$atm = $client->locateATMS($zip, $lat, $lon, $radius, $page, $per_page);
//var_dump($dummy);


$entity = (object) [
  "cryptocurrency" => True,
  "gambling" => False,
  "document_id" => "2a4a5957a3a62aaac1a0dd0edcae96ea2cdee688ec6337b20745eed8869e3ac8"
];
$signer = (object) [
  "relationship_to_entity" => "CEO",
  "document_id" => "2a4a5957a3a62aaac1a0dd0edcae96ea2cdee688ec6337b20745eed8869e3ac8"
];
$compliance = (object) [
  "relationship_to_entity" => "CEO",
  "document_id" => "2a4a5957a3a62aaac1a0dd0edcae96ea2cdee688ec6337b20745eed8869e3ac8"
];
$primary = (object) [
  "relationship_to_entity" => "CEO",
  "document_id" => "2a4a5957a3a62aaac1a0dd0edcae96ea2cdee688ec6337b20745eed8869e3ac8"
];
$entitydoc = (object)[
  "entity_info" => $entity,
  "signer" => $signer,
  "compliance_contact" => $compliance,
  "primary_controlling_contact" => $primary
];
$microArray = array();
$microArray[] = 0.1;
$microArray[] = 0.1;
$micro = (object) [
  "micro" => $microArray
];
$cardinfo = (object) [
  "nickname" => "Mr.T's Debit Card",
  "document_id" => "2a4a5957a3a62aaac1a0dd0edcae96ea2cdee688ec6337b20745eed8869e3ac8",
  "card_type" => "VIRTUAL"
];
$cardbody = (object)[
  "type" => "CARD-US",
  "info" => $cardinfo
];

$mfa = (object) [
  "access_token" => "fake_cd60680b9addc013ca7fb25b2b70",
  "mfa_answer" =>"test_answer"
];
$info= (object) [
  "nickname" => "End User Debit Card",
  "document_id" => "298a19e0336be28dfcad283d8f6a11d7efac1877e0ea1744504805075cccabf8"
];
$ship = (object)[
  "fee_node_id" =>"5c05a5b0ce316700ab2a568a",
  "expedite" => True
];
$card_us_object = (object) [
  'type' => 'CARD-US',
  'info' => $info
];



//var_dump("loginach", $loginsach);
//$mfanode = $user->createNodeMFA($mfa);
//var_dump("mfa", $mfanode);

// $reinit = (object)[];
// //"Unable to verify node since node permissions are CREDIT-AND-DEBIT."
// $reinitmicro = $user->reinitiateMicrodeposits('5c05a5b0ce316700ab2a568a', $reinit);
// var_dump($reinitmicro);

//
// $reset = (object)[];
// //"Unable to verify node since node permissions are CREDIT-AND-DEBIT."
// $resetdebit = $user->resetDebitCard('5c05a5b0ce316700ab2a568a', $reset);
// var_dump($resetdebit);


$body = (object) [
  "supp_id" => "new_supp_id_1234"
];
$info= (object) [
  "nickname" => "My Debit Card",
  "document_id" => "5c0199fe3c4e280a7d7c2a31"
];
$card_us_object = (object) [
  'type' => 'ACH-US',
  'info' => $info
];

$infoachus = (object)[
  "bank_id" => "synapse_good",
  "bank_pw" => "test1234",
  "bank_name" => "fake"
];
$mfa = (object)[
    "access_token" => "fake_cd60680b9addc013ca7fb25b2b70",
    "mfa_answer" => "test_answer"
];
$ach = (object) [
  "type" => "ACH-US",
  "info" => $infoachus
];

$user = $client->getUser('5c0199fe3c4e280a7d7c2a31');
//var_dump("USER", $user);

$newnode = $user->createNode($ach);

//var_dump("mfa!!", $newnode);


// $body = (object)[
//   "certificate" => "your applepay cert",
//   "nonce" => "9c02xxx2",
//   "nonce_signature" => "4082f883ae62d0700c283e225ee9d286713ef74"
// ];
// $result = $user->generate_apple_pay('5c0abc754f98b000bc81c0ca', $body);
// var_dump("result", $result);
// $applepaybody = (object) [
//     "certificate" => "your applepay cert",
//     "nonce" => "9c02xxx2",
//     "nonce_signature" => "4082f883ae62d0700c283e225ee9d286713ef74"
// ];
// $applepaytoken = $user->generate_apple_pay('5c05ae9fce316700ab2a571f', $applepaybody);
// var_dump("apple pay token", $applepaytoken);



?>
