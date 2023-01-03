<?php
include 'Node.php';
include 'Subnets.php';
include 'Subnet.php';
include 'Transaction.php';

class User
{

function __construct($userObj) {
   $this->oauth = $userObj->oauth;
   $this->id = $userObj->id;
   $this->body =  $userObj->payload;
   $this->base_url = $userObj->base_url;
   $this->fingerprint = $userObj->fingerprint;
   $this->handle202 = $userObj->handle202;
   $this->logging = $userObj->logging;

   $this->headers = (object) [
     'XSPGATEWAY' => $userObj->XSPGATEWAY,
     'XSPUSERIP' => $userObj->XSPUSERIP,
     'XSPUSER' => $userObj->XSPUSER,
     'ContentType' => $userObj->ContentType
   ];
 }

function oauth($body){
  $url = $this->base_url . 'oauth/' . $this->id;
  if($this->logging){
    var_dump("oauthuser", $url);
  }
  $http = new HttpClient();
  $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
  $payload =  $http->post($this->headers, $url, $body);

  $errormessage = $payload->error->en;
  $errorcode = $payload->error_code;
  $httpcode= $payload->http_code;
   try{
     $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
   }
   catch(SynapseException $e){
     return $e;
   }
  return $payload;
}

function confirm_2fa_pin($body){
  $url = $this->base_url . 'oauth/' . $this->id;
  if($this->logging){
    var_dump("confirm_2fa_pin", $url);
  }
  $http = new HttpClient();
  $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
  $payload =  $http->post($this->headers, $url, $body);

  $errormessage = $payload->error->en;
  $errorcode = $payload->error_code;
  $httpcode= $payload->http_code;
   try{
     $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
   }
   catch(SynapseException $e){
     return $e;
   }
  return $payload;
}

function select_2fa_device($body){
  $url = $this->base_url . 'oauth/' . $this->id;
  if($this->logging){
    var_dump("select_2fa_device", $url);
  }
  $http = new HttpClient();
  $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
  $payload =  $http->post($this->headers, $url, $body);

  $errormessage = $payload->error->en;
  $errorcode = $payload->error_code;
  $httpcode= $payload->http_code;
   try{
     $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
   }
   catch(SynapseException $e){
     return $e;
   }
  return $payload;
}

function update_node($nodeid, $body){
   $userid = $this->id;
   $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid;
   if($this->logging){
     var_dump("update node", $url);
   }
   $http = new HttpClient();
   $this->headers->XSPUSER = $this->oauth . $this->headers->XSPUSER;
   $payload =  $http->patch($this->headers, $url, $body);
   while (is_string($payload)){
     var_dump("yeah we have an oauth error!");
     $this->oauth = $this->refresh();
     $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
     $payload =  $http->patch($this->headers, $url, $body);
    }
  $errormessage = $payload->error->en;
  $errorcode = $payload->error_code;
  $httpcode= $payload->http_code;
   try{
     $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
   }
   catch(SynapseException $e){
     return $e;
   }
   $nodeType = $payload->type;
   $newNode = new Node($payload, $this->id, $nodeid, $nodeType);
   return $newNode;
}

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
  if ($http_code == '405'){
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

function refresh(){
  $userid = $this->id;
  $http = new HttpClient();
  $url = $this->base_url . "users/" . $userid;
  if($this->logging){
    var_dump("refresh()", $url);
  }
  $user = $http->get($this->headers, $url);
  $refreshtoken = $user->refresh_token;
  $refreshobj = (object)[
    "refresh_token" => $refreshtoken
  ];

  $oauthurl = $this->base_url . "oauth/" . $userid;
  $oauthobj = $http->post($this->headers, $oauthurl, $refreshobj);
  $oauthkey = $oauthobj->oauth_key;
  return $oauthkey;

}

//create ach node with multi factor authentication
function submit_mfa($node_body,$idempotency_key = null){

  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid . "/nodes";
  if($this->logging){
    var_dump("submit_mfa()", $url);
  }
  $http = new HttpClient();
  if($idempotency_key){
    if($this->logging){
      var_dump("idempotency_key is set");
    }
    $this->headers->XSPIDEMPOTENCYKEY = $idempotency_key;
  }
  $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
  $payload = $http->post($this->headers, $url, $node_body);
  while (is_string($payload)){
    $this->oauth = $this->refresh();
    $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
    $payload = $http->post($this->headers, $url, $node_body);
  }
  //var_dump("payload", $payload);
 $errormessage = $payload->error->en;
 $errorcode = $payload->error_code;
 $httpcode= $payload->http_code;
  try{
    $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
  }
  catch(SynapseException $e){
    return $e;
  }

  if($httpcode == 200){
    $numNodes = $payload->node_count;
    $limit = $payload->limit;
    $page_count = $payload->page_count;
    $listOfNodes = array();
    foreach ($payload->nodes as $obj) {
        $nodeid= $obj->_id;
        $userid= $obj->user_id;
        $type = $obj->type;
        $payload = $obj;
        $node = new Node($payload,$userid, $nodeid, $type);
        $listOfNodes[] = $node;
    }
    $nodes = new Nodes($numNodes, $listOfNodes, $page, $page_count, $limit);
    return $nodes;
  }
  elseif($httpcode == 202){
    return $payload;
  }

}

//creates a node for specific user
function create_node($node_body, $idempotency_key = null){
    $userid = $this->id;
    $url = $this->base_url . "users/" . $userid . "/nodes";
    if($this->logging){
      var_dump("create_node", $url);
    }
    $http = new HttpClient();
    if($idempotency_key){
      if($this->logging){
        var_dump("idempotency_key is set");
      }
      $this->headers->XSPIDEMPOTENCYKEY = $idempotency_key;
    }
    $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
    $payload = $http->post($this->headers, $url, $node_body);
    while (is_string($payload)){
      $this->oauth = $this->refresh();
      $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
      $payload = $http->post($this->headers, $url, $node_body);
    }
   $errormessage = $payload->error->en;
   $errorcode = $payload->error_code;
   $httpcode= $payload->http_code;
    try{
      $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
    }
    catch(SynapseException $e){
      return $e;
    }
   if($httpcode == 200){
     $numNodes = $payload->node_count;
     $limit = $payload->limit;
     $page_count = $payload->page_count;
     $listOfNodes = array();
     foreach ($payload->nodes as $obj) {
         $nodeid= $obj->_id;
         $userid= $obj->user_id;
         $type = $obj->type;
         $payload = $obj;
         $node = new Node($payload,$userid, $nodeid, $type);
         $listOfNodes[] = $node;
     }
     $nodes = new Nodes($numNodes, $listOfNodes, $page, $page_count, $limit);
     return $nodes;
   }
   elseif ($httpcode == 202){
     return $payload;
   }
}

function get_node($nodeID, $full_dehydrate=null, $force_refresh = null){

  if(isset($full_dehydrate)){
    if(strtoupper($full_dehydrate) == 'YES'){
      $path = $path . '?full_dehydrate='.$full_dehydrate;
      if(strtoupper($force_refresh) == 'YES'){
        $path = $path . '&force_refresh='.$force_refresh;
      }
    }
  }
  elseif (strtoupper($force_refresh) == 'YES'){
    $path = $path . '?force_refresh='. $force_refresh;
  }
  $url = $this->base_url . 'users/' . $this->id . '/nodes' . '/' . $nodeID . $path;
  if($this->logging){
    var_dump("get_node", $url);
  }

  $http = new HttpClient();
  $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
  $payload = $http->get($this->headers, $url);
   while (is_string($payload)){
     $this->oauth = $this->refresh();
     $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
     $url = $this->base_url . "users/" .$userID . "/" . "nodes/" . $nodeID;
     $payload = $http->get($this->headers, $url);
   }
   $errormessage = $payload->error->en;
   $errorcode = $payload->error_code;
   $httpcode= $payload->http_code;

   try{
     $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
   }
   catch(SynapseException $e){
     return $e;
   }
   $nodeType = $payload->type;
   $newNode = new Node($payload, $this->id, $nodeID, $nodeType);
   return $newNode;
}

//Updates a user's information
function update_info($updateuserbody){

  $userid= $this->id;
  $oauthkey = $this->oauth;
  $url = $this->base_url . "users/" . $userid;
  if($this->logging){
    var_dump("update_info()", $url);
  }
  $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
  $http = new HttpClient();
  $updatedocresponse =  $http->patch($this->headers, $url, $updateuserbody);

  while (is_string($updatedocresponse)){
    if($this->logging){
      var_dump("oauth is expired");
    }
    $this->oauth = $this->refresh();
    $this->headers->XSPUSER = $this->oauth . $this->fingerprint;

    $updatedocresponse =  $http->patch($this->headers, $url, $updateuserbody);
   }
  $errormessage = $updatedocresponse->error->en;
  $errorcode = $updatedocresponse->error_code;
  $httpcode= $updatedocresponse->http_code;
  try{
    $this->checkForErrors($httpcode, $errormessage, $errorcode, $updatedocresponse);
  }
  catch(SynapseException $e){
    return $e;
  }
  return $updatedocresponse;
}

//Use this call if you want the transaction statement for the specific user.
function get_user_statements($page=null, $per_page=null){
  $url = $this->base_url . 'users' . '/' . $this->id . '/statements';
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
     var_dump("get all user statements", $url);
   }
   $http = new HttpClient();
   $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
   $userStatements = $http->get($this->headers, $url);

   while (is_string($userStatements)){
     $this->oauth = $this->refresh();
     $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
     $userStatements = $http->get($this->headers, $url);
   }
   $errormessage = $userStatements->error->en;
   $errorcode = $userStatements->error_code;
   $httpcode= $userStatements->http_code;
   try{
     $this->checkForErrors($httpcode, $errormessage, $errorcode, $userStatements);
   }
   catch(SynapseException $e){
     return $e;
   }
   return $userStatements;
}

//Use this call if you want the transaction statement for a specific node
function get_node_statements($nodeid, $page=null, $per_page=null){
  $url = $this->base_url . 'users' . '/' . $this->id . '/nodes' . '/' . $nodeid . '/statements';
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
     var_dump("get all user statements", $url);
   }

   $http = new HttpClient();
   $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
   $nodeStatements = $http->get($this->headers, $url);

   while (is_string($nodeStatements)){
     $this->oauth = $this->refresh();
     $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
     $nodeStatements = $http->get($this->headers, $url);
   }
   $errormessage = $nodeStatements->error->en;
   $errorcode = $nodeStatements->error_code;
   $httpcode= $nodeStatements->http_code;
   try{
     $this->checkForErrors($httpcode, $errormessage, $errorcode, $nodeStatements);
   }
   catch(SynapseException $e){
     return $e;
   }
   return $nodeStatements;
}

//get all transactions from the node
function get_all_node_trans($nodeid, $page=null, $per_page=null){
    $url = $this->base_url . 'users/' . $this->id . '/nodes' . '/' . $nodeid . '/trans';
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
       var_dump("get all node transactions", $url);
     }

     $http = new HttpClient();
     $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
     $userTransactions= $http->get($this->headers, $url);

     while (is_string($userTransactions)){
       $this->oauth = $this->refresh();
       $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
       $userTransactions = $http->get($this->headers, $url);
     }

     $errormessage = $userTransactions->error->en;
     $errorcode = $userTransactions->error_code;
     $httpcode= $userTransactions->http_code;
     try{
       $this->checkForErrors($httpcode, $errormessage, $errorcode, $userTransactions);
     }
     catch(SynapseException $e){
       return $e;
     }
     $numTrans = $userTransactions->trans_count;
     $limit = $userTransactions->limit;
     $page_count = $userTransactions->page_count;
     $page = $userTransactions->page;
    $listOfTrans = array();
    foreach ($userTransactions->trans as $obj) {
      $trans = new Transaction($obj->_id, $obj);
      $listOfTrans[] = $trans;
    }
    $trans = new Transactions($numTrans, $listOfTrans, $limit, $page_count, $page);
    return $trans;
}

function get_all_transactions($page=null, $per_page=null){
    $url = $this->base_url . 'users/' . $this->id . '/trans';
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
     $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
     $userTransactions= $http->get($this->headers, $url);

     while (is_string($userTransactions)){
       $this->oauth = $this->refresh();
       $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
       $userTransactions = $http->get($this->headers, $url);
     }

     $errormessage = $userTransactions->error->en;
     $errorcode = $userTransactions->error_code;
     $httpcode= $userTransactions->http_code;
     try{
       $this->checkForErrors($httpcode, $errormessage, $errorcode, $userTransactions);
     }
     catch(SynapseException $e){
       return $e;
     }
     $numTrans = $userTransactions->trans_count;
     $limit = $userTransactions->limit;
     $page_count = $userTransactions->page_count;
     $page = $userTransactions->page;
    $listOfTrans = array();
    foreach ($userTransactions->trans as $obj) {
      $trans = new Transaction($obj->_id, $obj);
      $listOfTrans[] = $trans;
    }
    $trans = new Transactions($numTrans, $listOfTrans, $limit, $page_count, $page);
    return $trans;
}

function get_all_nodes($page = null, $per_page = null, $type = null){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid . "/nodes";

  if($page){
			$path = $path . '?page=' . $page;
			if($per_page){
				$path = $path . '&per_page=' . $per_page;
			}
			if($node_type){
				$path = $path . '&type=' . $node_type;
			}
		}elseif($per_page){
			$path = $path . '?per_page=' . $per_page;
			if($node_type){
				$path = $path . '&type=' . $node_type;
			}
		}elseif($node_type){
			$path = $path . '?type=' . $node_type;
		}
  $url = $url . $path;

  if($this->logging){
    var_dump("get_all_nodes()", $url);
  }

  $http = new HttpClient();
  $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
  $payload = $http->get($this->headers, $url);
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

function generate_apple_pay($nodeid, $body){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid . "/applepay";
  if($this->logging){
    var_dump("generate apple pay", $url);
  }
  $http = new HttpClient();
  $this->headers->XSPUSER = $this->oauth . $this->headers->XSPUSER;
  $payload =  $http->patch($this->headers, $url, $body);

  while (is_string($payload)){
    if($this->logging){
      var_dump("oauth is invalid");
    }
    $this->oauth = $this->refresh();
    $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
    $payload =  $http->patch($this->headers, $url, $body );
   }
    $errormessage = $payload->error->en;
    $errorcode = $payload->error_code;
    $httpcode= $payload->http_code;
  try{
    $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
  }
  catch(SynapseException $e){
    return $e;
  }

  return $payload;
}

// CreateUBO creates and uploads an Ultimate Beneficial Ownership (UBO) and REG GG form as a physical document under the Business’s base document
function create_ubo($entitydoc, $idempotency_key=null){
  $userid = $this->id;
  $url = $this->base_url . 'users/' . $userid .'/ubo';

  if($this->logging){
    var_dump("generate UBO FORM url", $url);
  }
  $http = new HttpClient();
  if($idempotency_key){
    if($this->logging){
      var_dump("idempotency_key is set");
    }
    $this->headers->XSPIDEMPOTENCYKEY = $idempotency_key;
  }
  $this->headers->XSPUSER = $this->oauth . $this->headers->XSPUSER;
  $payload = $http->patch($this->headers, $url, $entitydoc);
  while (is_string($payload)){
    $this->oauth = $this->refresh();
    $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
    $payload = $http->patch($this->headers, $url, $entitydoc);
   }
 $errormessage = $payload->error->en;
 $errorcode = $payload->error_code;
 $httpcode= $payload->http_code;
  try{
    $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
  }
  catch(SynapseException $e){
    return $e;
  }

  return $payload;
}

function delete_node($nodeID){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeID;
  if($this->logging){
    var_dump("delete node url", $url);
  }

  $http = new HttpClient();
  $this->headers->XSPUSER = $this->oauth . $this->headers->XSPUSER;
  $payload =  $http->delete($this->headers, $url);

  while (is_string($payload)){
    if($this->logging){
      var_dump("oauth is expired");
    }
    $this->oauth = $this->refresh();
    $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
    $payload =  $http->delete($this->headers, $url);
   }
 $errormessage = $payload->error->en;
 $errorcode = $payload->error_code;
 $httpcode= $payload->http_code;
  try{
    $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
  }
  catch(SynapseException $e){
    return $e;
  }
  return $payload;
}

//Micro-deposits verify that a user has access to an account.
function verify_micro($nodeid, $micro){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid;

  if($this->logging){
    var_dump("verify micro deposit", $url);
  }

  $http = new HttpClient();
  $this->headers->XSPUSER = $this->oauth . $this->headers->XSPUSER;
  $payload =  $http->patch($this->headers, $url, $micro );
  while (is_string($payload)){
    if($this->logging){
      var_dump("oauth error");
    }
    $this->oauth = $this->refresh();
    $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
    $payload =  $http->patch($this->headers, $url, $micro);
   }

 $errormessage = $payload->error->en;
 $errorcode = $payload->error_code;
 $httpcode= $payload->http_code;
  try{
    $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
  }
  catch(SynapseException $e){
    return $e;
  }

  $nodeType = $payload->type;
  $newNode = new Node($payload, $this->id, $nodeid, $nodeType);
  return $newNode;
}

//use in instances after the debit card number has been created and a physical card is requested
function ship_debit($nodeid, $body){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid . '?ship=YES';
  if($this->logging){

    var_dump("ship_debit()", $url);
  }
  $http = new HttpClient();
  $this->headers->XSPUSER = $this->oauth . $this->headers->XSPUSER;
  $payload =  $http->patch($this->headers, $url, $body );
  //var_dump("micro", $payload);
  while (is_string($payload)){
    $this->oauth = $this->refresh();
    $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
    $payload =  $http->patch($this->headers, $url, $body );
   }
 $errormessage = $payload->error->en;
 $errorcode = $payload->error_code;
 $httpcode= $payload->http_code;
  try{
    $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
  }
  catch(SynapseException $e){
    return $e;
  }
  $nodeType = $payload->type;
  $newNode = new Node($payload, $this->id, $nodeid, $nodeType);
  return $newNode;
}

//ship a card for subnets
function ship_card_subnet($nodeid, $subnetid, $body){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid . "/" . "subnets/" . $subnetid . '/ship';
  if($this->logging){
    var_dump("ship_debit()", $url);
  }
  $http = new HttpClient();
  $this->headers->XSPUSER = $this->oauth . $this->headers->XSPUSER;
  $payload =  $http->patch($this->headers, $url, $body );
  //var_dump("micro", $payload);
  while (is_string($payload)){
    $this->oauth = $this->refresh();
    $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
    $payload =  $http->patch($this->headers, $url, $body );
   }
 $errormessage = $payload->error->en;
 $errorcode = $payload->error_code;
 $httpcode= $payload->http_code;
  try{
    $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
  }
  catch(SynapseException $e){
    return $e;
  }
  $nodeType = $payload->type;
  $newNode = new Node($payload, $this->id, $nodeid, $nodeType);
  return $newNode;
}

function reinit_micro($nodeid){
  $micro  = new stdClass();
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid . '?resend_micro=YES';;
  if($this->logging){
    var_dump("reinit_micro()", $url);
  }
  $http = new HttpClient();
  $this->headers->XSPUSER = $this->oauth . $this->headers->XSPUSER;
  $payload =  $http->patch($this->headers, $url, $micro );
  while (is_string($payload)){
    $this->oauth = $this->refresh();
    $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
    $payload =  $http->patch($this->headers, $url, $micro );
   }
 $errormessage = $payload->error->en;
 $errorcode = $payload->error_code;
 $httpcode= $payload->http_code;
  try{
    $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
  }
  catch(SynapseException $e){
    return $e;
  }
  $nodeType = $payload->type;
  $newNode = new Node($payload, $this->id, $nodeid, $nodeType);
  return $newNode;
}

//In cases of stolen or lost cards, you can use this function to reset card information
function reset_debit($nodeid){
  $debit  = new stdClass();
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid . '?reset=YES';;
  if($this->logging){
    var_dump("reset_debit()", $url);
  }
  $http = new HttpClient();
  $this->headers->XSPUSER = $this->oauth . $this->headers->XSPUSER;
  $payload =  $http->patch($this->headers, $url, $debit);
  while (is_string($payload)){
    $this->oauth = $this->refresh();
    $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
    $payload =  $http->patch($this->headers, $url, $debit );
   }
 $errormessage = $payload->error->en;
 $errorcode = $payload->error_code;
 $httpcode= $payload->http_code;
  try{
    $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
  }
  catch(SynapseException $e){
    return $e;
  }
  $nodeType = $payload->type;
  $newNode = new Node($payload, $this->id, $nodeid, $nodeType);
  return $newNode;
}

//view the transaction detail
function get_trans($nodeid, $transid){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid  . "/" . "trans/" . $transid;
  if($this->logging){
    var_dump("get_trans()", $url);
  }
  $http = new HttpClient();
  $this->headers->XSPUSER = $this->oauth . $this->headers->XSPUSER;
  $payload =  $http->get($this->headers, $url);
  while (is_string($payload)){
    $this->oauth = $this->refresh();
    $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
    $payload =  $http->get($this->headers, $url);
   }
 $errormessage = $payload->error->en;
 $errorcode = $payload->error_code;
 $httpcode= $payload->http_code;
  try{
    $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
  }
  catch(SynapseException $e){
    return $e;
  }

  $transid = $payload->_id;
  $trans = new Transaction($transid, $payload);
  return $trans;

}


function cancel_trans($nodeid, $transid){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid  . "/" . "trans/" . $transid;
  if($this->logging){
    var_dump("cancel_trans()", $url);
  }
  $http = new HttpClient();
  $this->headers->XSPUSER = $this->oauth . $this->headers->XSPUSER;
  $payload =  $http->delete($this->headers, $url);

  while (is_string($payload)){
    $this->oauth = $this->refresh();
    $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
    $payload =  $http->delete($this->headers, $url);
   }
 $errormessage = $payload->error->en;
 $errorcode = $payload->error_code;
 $httpcode= $payload->http_code;
  try{
    $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
  }
  catch(SynapseException $e){
    return $e;
  }

  $transid = $payload->_id;
  $trans = new Transaction($transid, $payload);
  return $trans;

}


//create a transaction from the node specified
function create_trans($nodeid, $body, $idempotency_key = null){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/" . $nodeid . "/" . "trans";
  if($this->logging){
    var_dump("createTransaction()", $url);
  }
  $http = new HttpClient();
  if($idempotency_key){
    if($this->logging){
      var_dump("idempotency_key is set");
    }
    $this->headers->XSPIDEMPOTENCYKEY = $idempotency_key;
  }
  $this->headers->XSPUSER = $this->oauth . $this->headers->XSPUSER;
  $payload =  $http->post($this->headers, $url, $body);

  while (is_string($payload)){
    $this->oauth = $this->refresh();
    $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
    $payload =  $http->post($this->headers, $url, $body);
   }

  $transid = $payload->_id;
  $trans = new Transaction($transid, $payload);
  return $trans;
}

//Generates test transaction from an EXTERNAL-US account
function dummy_tran($nodeid, $is_credit=null){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid  . "/" . "dummy-tran";
  if($is_credit){
    $path = '?is_credit=' . $is_credit;
  }
  $url = $url . $path;
  if($this->logging){
    var_dump("dummy_tran()", $url);
  }
  $http = new HttpClient();
  $this->headers->XSPUSER = $this->oauth . $this->headers->XSPUSER;
  $payload = $http->get($this->headers, $url);
  while (is_string($payload)){
    if($this->logging){
    var_dump("yeah we have an oauth error!");
    }
    $this->oauth = $this->refresh();
    $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
    $payload =  $http->get($this->headers, $url );
 }
 $errormessage = $payload->error->en;
 $errorcode = $payload->error_code;
 $httpcode= $payload->http_code;
  try{
    $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
  }
  catch(SynapseException $e){
    return $e;
  }
  return $payload;
}

//add a comment to user transaction
function comment_trans($nodeid, $transid, $body){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid  . "/" . "trans/" . $transid;
  if($this->logging){
    var_dump("comment_trans()", $url);
  }
  $http = new HttpClient();
  $this->headers->XSPUSER = $this->oauth . $this->headers->XSPUSER;
  $payload =  $http->patch($this->headers, $url, $body, $userid);

  while (is_string($payload)){

    if($this->logging){
    var_dump("yeah we have an oauth error!");
    }
    $this->oauth = $this->refresh();
    $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
    $payload =  $http->patch($this->headers, $url, $body, $userid);
   }

    $errormessage = $payload->error->en;
    $errorcode = $payload->error_code;
    $httpcode= $payload->http_code;
    try{
      $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
    }
    catch(SynapseException $e){
      return $e;
    }
    return $payload;
}

//Dispute a transaction for the user
function dispute_trans($nodeid, $transid, $body){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid  . "/" . "trans/" . $transid . "/dispute";
  if($this->logging){var_dump("dispute_trans()", $url);}

  $http = new HttpClient();
  $this->headers->XSPUSER = $this->oauth . $this->headers->XSPUSER;
  $payload =  $http->patch($this->headers, $url, $body);
  while (is_string($payload)){
    if($this->logging){var_dump("yeah we have an oauth error!");}
    $this->oauth = $this->refresh();
    $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
    $payload =  $http->patch($this->headers, $url, $body);
   }

 $errormessage = $payload->error->en;
 $errorcode = $payload->error_code;
 $httpcode= $payload->http_code;
  try{
    $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
  }
  catch(SynapseException $e){
    return $e;
  }
  return $payload;
}
//deletes a transaction for specific node
function delete_transaction($nodeid, $transid){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid  . "/" . "trans/" . $transid;
  if($this->logging){var_dump("deleteTransaction()", $url);}

  $http = new HttpClient();
  $this->headers->XSPUSER = $this->oauth . $this->headers->XSPUSER;
  $payload =  $http->delete($this->headers, $url);

  while (is_string($payload)){
    if($this->logging){var_dump("yeah we have an oauth error!");}
    $this->oauth = $this->refresh();
    $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
    $payload =  $http->delete($this->headers, $url );
   }

 $errormessage = $payload->error->en;
 $errorcode = $payload->error_code;
 $httpcode= $payload->http_code;
  try{
    $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
  }
  catch(SynapseException $e){
    return $e;
  }
  return $payload;
}
//platform not allowed to add subnets
function create_subnet($nodeid, $body, $idempotency_key = null){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid . '/subnets';
  if($this->logging){var_dump("create_subnet()", $url);}
  $http = new HttpClient();
  if($idempotency_key){
    if($this->logging){
      var_dump("idempotency_key is set");
    }
    $this->headers->XSPIDEMPOTENCYKEY = $idempotency_key;
  }
  $this->headers->XSPUSER = $this->oauth . $this->headers->XSPUSER;
  $payload =  $http->post($this->headers, $url, $body);
  while (is_string($payload)){
    if($this->logging){var_dump("yeah we have an oauth error!");}
    $this->oauth = $this->refresh();
    $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
    $payload =  $http->post($this->headers, $url, $body);
   }
 $errormessage = $payload->error->en;
 $errorcode = $payload->error_code;
 $httpcode= $payload->http_code;
  try{
    $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
  }
  catch(SynapseException $e){
    return $e;
  }
  $subnetid = $payload->_id;
  $subnet = new Subnet($nodeid, $subnetid, $userid, $payload );
  return $subent;
}

function get_subnet($nodeid, $subnetid){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid . '/subnets' . '/' . $subnetid;
  if($this->logging){var_dump("getSubnet()", $url);}
  $http = new HttpClient();
  $this->headers->XSPUSER = $this->oauth . $this->headers->XSPUSER;
  $payload =  $http->get($this->headers, $url );

  while (is_string($payload)){
    if($this->logging){var_dump("yeah we have an oauth error!");}
    $this->oauth = $this->refresh();
    $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
    $payload =  $http->get($this->headers, $url );
   }
  $errormessage = $payload->error->en;
  $errorcode = $payload->error_code;
  $httpcode= $payload->http_code;
  try{
    $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
  }
  catch(SynapseException $e){
    return $e;
  }
  $subnetid = $payload->_id;
  $subnet = new Subnet($nodeid, $subnetid, $userid, $payload );
  return $subnet;
}

function get_subnets($nodeid, $page=null, $per_page=null){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid . '/subnets';
  if($page){
    $path = $path . '?page=' . $page;
    if($per_page){
      $path = $path . '&per_page=' . $per_page;
    }
  }elseif($per_page){
    $path = $path . '?per_page=' . $per_page;
  }

  $url = $url . $path;

  if($this->logging){var_dump("get_subnets()", $url);}
  $http = new HttpClient();
  $this->headers->XSPUSER = $this->oauth . $this->headers->XSPUSER;
  $payload =  $http->get($this->headers, $url );
  //var_dump("micro", $payload);
  while (is_string($payload)){
    if($this->logging){
    var_dump("yeah we have an oauth error!");
    }
    $this->oauth = $this->refresh();
    $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
    $payload =  $http->get($this->headers, $url);
   }
 $errormessage = $payload->error->en;
 $errorcode = $payload->error_code;
 $httpcode= $payload->http_code;
  try{
    $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
  }
  catch(SynapseException $e){
    return $e;
  }
  $page = $payload->page;
  $listOfTrans = array();
  foreach ($payload->subnets as $obj) {
    $subnetid = $obj->_id;
    $user_id = $obj->user_id;
    $subnet = new Subnet($nodeid, $subnetid, $user_id, $payload );
    $list[] = $subnet;
  }
  $subents = new Subnets($nodeid, $list, $page, $per_page);
  return $subents;
}

function update_subnet($nodeid, $subnetid, $body){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid . '/subnets' . '/' . $subnetid;
  if($this->logging){var_dump("update_subnet()", $url);}
  $http = new HttpClient();

  $this->headers->XSPUSER = $this->oauth . $this->headers->XSPUSER;
  $payload =  $http->patch($this->headers, $url, $body);
  while (is_string($payload)){
    if($this->logging){var_dump("yeah we have an oauth error!");}
    $this->oauth = $this->refresh();
    $this->headers->XSPUSER = $this->oauth . $this->fingerprint;
    $payload =  $http->patch($this->headers, $url, $body);
   }
   $errormessage = $payload->error->en;
   $errorcode = $payload->error_code;
   $httpcode= $payload->http_code;
    try{
      $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
    }
    catch(SynapseException $e){
      return $e;
    }
    $subnetid = $payload->_id;
    $subnet = new Subnet($nodeid, $subnetid, $userid, $payload );
    return $subnet;
}

function registerNewFingerPrint($obj){
  $userid = $this->id;
  $http = new HttpClient();
  $regfingerprinturl = $this->base_url . "oauth/" . $userid;
  if($this->logging){
    var_dump("registerNewFingerPrint() obj", $obj);
  }
  $fingerPrintObj = $http->post($this->headers, $regfingerprinturl, $obj);
  return $fingerPrintObj;
}


} // class Users


?>
