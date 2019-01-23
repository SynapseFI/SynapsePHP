<?php
//namespace synapse_rest;

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
  public $logging;

//client constructor determines the headers, development mode, and logging
  function __construct($clientObj) {

    $this->clientId = $clientObj->client_id;
    $this->clientSecret = $clientObj->client_secret;
    $this->fingerPrint = $clientObj->fingerprint;
    $this->ipAddress = $clientObj->ip_address;
    $this->full_dehydrate = $clientObj->full_dehydrate;
    $this->devmode = $clientObj->devmode;
    $this->handle202 = $clientObj->handle202;
    $this->logging = $clientObj->logging;

    if($this->devmode == True){
      $this->base_url = 'https://uat-api.synapsefi.com/v3.1/' ;
    }
    else{
      $this->base_url = 'https://api.synapsefi.com/v3.1/' ;
    }
    if (isset($options['logging'])) {
      $this->logging = $options['logging'];
    }
    $this->headersObj = (object) [
      'XSPGATEWAY' => $clientObj->client_id . '|' . $clientObj->client_secret,
      'XSPUSERIP' => $this->ipAddress,
      'XSPUSER' => '|' . $this->fingerPrint,
      'ContentType' => 'application/json',
      'base_url' => $this->base_url,
      'XSPIDEMPOTENCYKEY' => $clientObj->$idempotency_key
    ];
    $httpclient = new HttpClient($this->headersObj);
  }

  //get the most recent refresh token
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

  //this function returns a user object
  function get_user($userid, $full_dehydrate= null) {
      $url = $this->base_url . "users/" . $userid;
      if(isset($full_dehydrate)){
          $url = $this->base_url . "users/" . $userid . '?full_dehydrate=' . $full_dehydrate;
      }
      if($this->logging){
        var_dump("getUser()", $url);
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
        'fingerprint' => '|' . $this->fingerPrint,
        'handle202' =>$this->handle202,
        'logging' => $this->logging
      ];

      $user = new User($returnObj);
      return $user;
  }

  //the response httpcode from a http request is passsed to this function
  function checkForErrors($http_code, $error_message, $error_code, $response){

    if($this->handle202){
      if ($http_code == '202'){
        throw new SynapseException($http_code, $error_message, $error_code, $response);
      }
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

  //this function returns a user object
  function create_user($body, $idempotency_key=null) {
    $url = $this->base_url . "users";
    $http = new HttpClient();
    if($idempotency_key){
      if($this->logging){
        var_dump("IDEMPOTENCY is set");
      }
      $this->headersObj->XSPIDEMPOTENCYKEY = $idempotency_key;
    }
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
      'fingerprint' => '|' . $this->fingerPrint,
      'handle202' =>$this->handle202,
      'logging' => $this->logging];
    $user = new User($returnObj);
    return $user;
  }

  //this function returns a user object
  function get_all_users($query=null, $page=null, $per_page=null, $show_refresh=null) {
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
    if($this->logging){
      var_dump("get_all_users()", $url);
    }
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
        $ouathkey = $this->refresh($userid);
        $returnObj = (object) [
          'XSPGATEWAY' => $this->headersObj->XSPGATEWAY,
          'XSPUSERIP' => $this->headersObj->XSPUSERIP,
          'XSPUSER' => $this->headersObj->XSPUSER,
          'id' => $userid,
          'payload' => $obj,
          'oauth' => $ouathkey,
          'ContentType' => 'application/json',
          'fingerprint' => '|' . $this->fingerPrint,
          'handle202' =>$this->handle202,
          'logging' => $this->logging
        ];
        $user = new User($returnObj);
        $listOfUsers[] = $user;
      }
      $users = new Users($listOfUsers, $numUsers, $page, $page_count, $limit);
      return $users;
  }

  //this function returns a transaction object
  function get_all_transactions($page=null, $per_page=null){

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
     if($this->logging){
       var_dump("get_all_transactions()", $url);
     }
     $http = new HttpClient();
     $this->headersObj->XSPUSER = $this->oauth . $this->fingerprint;
     $allClientTransactions = $http->get($this->headersObj, $url);
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

  //this function returns a node object
  function get_all_nodes(){
    $url = $this->base_url . 'nodes';

    $http = new HttpClient();
    $allnodesobj = $http->get($this->headersObj, $url);

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
  }

  //this function returns a stdclass object
  function get_all_institutions(){
    $url = $this->base_url . 'institutions';
    if($this->logging){
      var_dump("get_all_institutions()", $url);
    }
    $http = new HttpClient();
    $allInstit = $http->get($this->headersObj, $url);

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

  function get_all_platform_nodes(){
    $userid = $this->id;
    $url = $this->base_url . "nodes";

    if($this->logging){
      var_dump("get_all_platform_nodes()", $url);
    }

    $http = new HttpClient();
    $payload = $http->get($this->headersObj, $url);
    while (is_string($payload)){
      $this->oauth = $this->refresh();
      $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
      $payload = $http->get($this->headers, $url);
    }
    $node_count = $payload->node_count;
    $page = $payload->page;
    $page_count = $payload->page_count;
    $limit = $payload->limit;
    $listOfNodes = array();
    foreach ($payload->nodes as $obj) {
        $nodeid= $obj->_id;
        $userid= $obj->user_id;
        $type = $obj->type;
        $payload = $obj;
        $node = new Node($payload,$userid, $nodeid, $type);
        $listOfNodes[] = $node;
    }
    $allnodes = new Nodes($node_count, $listOfNodes, $page, $page_count, $limit);
    return $allnodes;
    }

  //this function returns a subscription object
  function get_all_subscriptions($page = null, $per_page = null){
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

    if($this->logging){
      var_dump("get_all_subscriptions()", $url);
    }
    $http = new HttpClient();
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

  //this function returns a subscription object
  function get_subscription($subscriptionID){
    $url = $this->base_url . 'subscriptions/' . $subscriptionID;
    if($this->logging){
      var_dump("get_subscription()", $url);
    }

    $http = new HttpClient();
    $subscriptionRequest = $http->get($this->headersObj, $url);

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

  //this function returns a subscription object
  function create_subscription($subscriptionOBJ, $idempotency_key = null){
    if($idempotency_key){
      $this->headersObj->XSPIDEMPOTENCYKEY = $idempotency_key;
    }
    $url = $this->base_url . 'subscriptions';
    if($this->logging){
      var_dump("create_subscription()", $url);
    }

    $http = new HttpClient();
    $newsubscriptionOBJ = $http->post($this->headersObj, $url ,$subscriptionOBJ );

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

  //this function returns a subscription object
  function update_subscription($subscriptionID, $updatesubscriptionOBJ){
    $url = $this->base_url . "subscriptions/" . $subscriptionID;
    if($this->logging){
      var_dump("update_subscription()", $url);
    }
    $http = new HttpClient();
    $updatedSubscription =  $http->patch($this->headersObj, $url, $updatesubscriptionOBJ);

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

  //Get Webhook Logs for the client
  function get_webhook_logs(){
    $url = $this->base_url . 'subscriptions/logs';
    if($this->logging){
      var_dump("get_webhook_logs()", $url);
    }
    $http = new HttpClient();
    $subscriptionRequest = $http->get($this->headersObj, $url);

    $errormessage = $subscriptionRequest->error->en;
    $errorcode = $subscriptionRequest->error_code;
    $httpcode= $subscriptionRequest->http_code;
    try{
      $this->checkForErrors($httpcode, $errormessage, $errorcode, $subscriptionRequest);
    }
    catch(SynapseException $e){
      return $e;
    }
    return $subscriptionRequest;
  }
  //this function returns a stdclass object
  function issue_public_key($scope=null){
    $http = new HttpClient();
    if($scope){
    $url = $this->base_url . "client" . "?" . 'issue_public_key=YES'  . '&amp;scope=' . $scope;
    }
    else{
      $url = $url = $this->base_url . "client" . "?" . 'issue_public_key=YES';
    }
    $body =  $http->get($this->headersObj, $url);
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

  //this function returns a stdclass object
  function locate_atms($zip = null, $lat = null, $lon = null, $radius = null, $page = null, $per_page = null){
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

    if($this->logging){
      var_dump("locate_atms()", $url);
    }

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

  //this function returns a stdclass object
  function get_crypto_quotes(){
    $url = $this->base_url . 'nodes/crypto-quotes';
    if($this->logging){
      var_dump("get_crypto_quotes()", $url);
    }
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

  //this function returns a stdclass object
  function get_crypto_market_data($limit, $currency){

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
    if($this->logging){
      var_dump("get_crypto_market_data()", $url);
    }

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

}


?>
