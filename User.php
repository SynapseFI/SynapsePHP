<?php
include 'Node.php';
include 'Subnets.php';
include 'Subnet.php';
include 'Transaction.php';
//include 'HTTPHandler.php';
//include 'SynapseException.php';

class User
{

function __construct($userObj) {
   $this->oauth = $userObj->oauth;
   $this->id = $userObj->id;
   $this->payload =  $userObj->payload;
   $this->base_url = $userObj->base_url;
   $this->fingerprint = $userObj->fingerprint;
   $this->handle202 = $userObj->handle202;
   $this->printToConsole = $userObj->printToConsole;

   $this->headersObj = (object) [
     'XSPGATEWAY' => $userObj->XSPGATEWAY,
     'XSPUSERIP' => $userObj->XSPUSERIP,
     'XSPUSER' => $userObj->XSPUSER,
     'ContentType' => $userObj->ContentType
   ];
 }

function oauthuser($body){
  $url = $this->base_url . 'oauth/' . $this->id;
  if($this->printToConsole){
    var_dump("oauthuser", $url);
  }
  $http = new HttpClient();
  $this->headersObj->XSPUSER = $this->oauth . $this->fingerprint;
  $payload =  $http->post($this->headersObj, $url, $body);

  return $payload;
}

//this triggers a httpcode 405 or errorcode 300 when the wrong url is used for a patch method
function updateNode($nodeid, $body){
   $userid = $this->id;
   $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid;
   if($this->printToConsole){
     var_dump("update node", $url);
   }
   $http = new HttpClient();
   $this->headersObj->XSPUSER = $this->oauth . $this->headersObj->XSPUSER;
   $payload =  $http->patch($this->headersObj, $url, $body);
   while (is_string($payload)){
     var_dump("yeah we have an oauth error!");
     $this->oauth = $this->refresh();
     $payload =  $http->patch($this->headersObj, $url, $body);
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
  if($this->printToConsole){
    var_dump("refresh()", $url);
  }
  $user = $http->get($this->headersObj, $url);
  $refreshtoken = $user->refresh_token;
  $refreshobj = (object)[
    "refresh_token" => $refreshtoken
  ];

  $oauthurl = $this->base_url . "oauth/" . $userid;
  $oauthobj = $http->post($this->headersObj, $oauthurl, $refreshobj);
  $oauthkey = $oauthobj->oauth_key;
  return $oauthkey;

}

function createNodeMFA($node_body){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid . "/nodes";
  if($this->printToConsole){
    var_dump("createnodemfa", $url);
  }
  $http = new HttpClient();
  $this->headersObj->XSPUSER = $this->oauth . $this->fingerprint;
  $payload = $http->post($this->headersObj, $url, $node_body);
  //var_dump("return payload", $payload);
  while (is_string($payload)){
    $this->oauth = $this->refresh();
    $this->headersObj->XSPUSER = $this->oauth . $this->fingerprint;
    $payload = $http->post($this->headersObj, $url, $node_body);
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
  else{
    return $payload;
  }

}//createnodemfa

function createNode($node_body){
    $userid = $this->id;
    $url = $this->base_url . "users/" . $userid . "/nodes";
    if($this->printToConsole){
      var_dump("createnode", $url);
    }
    $http = new HttpClient();
    //var_dump("before", $this->headersObj->XSPUSER);
    $this->headersObj->XSPUSER = $this->oauth . $this->fingerprint;
    //$this->headersObj->XSPUSER = 'oauth_Jeq4vk8bY5MsVIN2crmu3901LoKSRGHpyziaAD6Pc' . $this->fingerprint;
    $payload = $http->post($this->headersObj, $url, $node_body);
    while (is_string($payload)){
      $this->oauth = $this->refresh();
      $this->headersObj->XSPUSER = $this->oauth . $this->fingerprint;
      $payload = $http->post($this->headersObj, $url, $node_body);
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

function getNode($nodeID, $full_dehydrate=null, $force_refresh = null){

    if(isset($full_dehydrate)){
    //  echo('isset is true');
      if(strtoupper($full_dehydrate) == 'YES'){
      //  echo('inaarray is true');
        $path = $path . '?full_dehydrate='.$full_dehydrate;
        if(strtoupper($force_refresh) == 'YES'){
            echo('inaarray is true again');
          $path = $path . '&force_refresh=='.$force_refresh;
        }
      }
    }
    elseif (strtoupper($force_refresh) == 'YES'){
      $path = $path . '&force_refresh=='. $force_refresh;
    }
  //var_dump("the path", $path);
  $url = $this->base_url . 'users/' . $this->id . '/nodes' . '/' . $nodeID . $path;

  if($this->printToConsole){
    var_dump("getnode", $url);
  }

  $http = new HttpClient();
  $this->headersObj->XSPUSER = $this->oauth . $this->fingerprint;

  $payload = $http->get($this->headersObj, $url);

   //$payload = getNodeRequests($this->headersObj, $this->id, $nodeID, $this->oauth);

   while (is_string($payload)){
     $this->oauth = $this->refresh();
     $this->headersObj->XSPUSER = $this->oauth . $this->fingerprint;
     $url = $this->base_url . "users/" .$userID . "/" . "nodes/" . $nodeID;
     $payload = $http->get($this->headersObj, $url);
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

function updateUser($updateuserbody){

  $userid= $this->id;
  $oauthkey = $this->oauth;
  $url = $this->base_url . "users/" . $userid;
  $this->headersObj->XSPUSER = $this->oauth . $this->fingerprint;

  $updatedocresponse = updateUserRequest($this->headersObj, $updateuserbody, $oauthkey, $userid );
  if($this->printToConsole){
    var_dump("updateuser", $url);
  }
  while (is_string($updatedocresponse)){
    var_dump("yeah we have an oauth error!");
    $this->oauth = $this->refresh();
    $this->headersObj->XSPUSER = $this->oauth . $this->fingerprint;
    $updatedocresponse =  $http->patch($this->headersObj, $url, $updateuserbody);
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

function deleteDocuments($updatedocsbody){

  $userid= $this->id;
  $oauthkey = $this->oauth;

  if($this->printToConsole){
    var_dump("deletedocument body", $updatedocsbody);
  }
  $updatedocresponse = updateDocumentsRequest($this->headersObj, $updatedocsbody, $oauthkey, $userid );
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

function addUserKYC($docbody){
    $oauthkey = $this->oauth;
    $userid= $this->id;

    if($this->printToConsole){
      var_dump("adduser body", $docbody);
    }
    $docresponse = addNewDocumentsRequest($this->headersObj, $docbody, $oauthkey, $userid );

    $errormessage = $docresponse->error->en;
    $errorcode = $docresponse->error_code;
    $httpcode= $docresponse->http_code;

    try{
      $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
    }
    catch(SynapseException $e){
      return $e;
    }

    return $docresponse;
}

function getAllUserStatements($page=null, $per_page=null){
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

   if($this->printToConsole){
     var_dump("get all user statements", $url);
   }
   $http = new HttpClient();
   $this->headersObj->XSPUSER = $this->oauth . $this->fingerprint;
   $userStatements = $http->get($this->headersObj, $url);

   while (is_string($userStatements)){
     $this->oauth = $this->refresh();
     $this->headersObj->XSPUSER = $this->oauth . $this->fingerprint;
     $userStatements = $http->get($this->headersObj, $url);
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

function getAllNodeStatements($nodeid, $page=null, $per_page=null){
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

   if($this->printToConsole){
     var_dump("get all user statements", $url);
   }

   $http = new HttpClient();
   $this->headersObj->XSPUSER = $this->oauth . $this->fingerprint;
   $nodeStatements = $http->get($this->headersObj, $url);

   while (is_string($nodeStatements)){
     $this->oauth = $this->refresh();
     $this->headersObj->XSPUSER = $this->oauth . $this->fingerprint;
     $nodeStatements = $http->get($this->headersObj, $url);
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

function getNodeTransactions($nodeid, $page=null, $per_page=null){
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
     if($this->printToConsole){
       var_dump("get all node transactions", $url);
     }

     $http = new HttpClient();
     $this->headersObj->XSPUSER = $this->oauth . $this->fingerprint;
     $userTransactions= $http->get($this->headersObj, $url);
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

function getUserTransactions($page=null, $per_page=null){
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

     if($this->printToConsole){
       var_dump("get all user transactions", $url);
     }

     $http = new HttpClient();
     $this->headersObj->XSPUSER = $this->oauth . $this->fingerprint;
     $userTransactions= $http->get($this->headersObj, $url);
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

function getNodes($page = null, $per_page = null, $type = null){
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

  if($this->printToConsole){
    var_dump("get nodes", $url);
  }

  $http = new HttpClient();
  $this->headersObj->XSPUSER = $this->oauth . $this->fingerprint;
  $payload = $http->get($this->headersObj, $url);
  while (is_string($payload)){
    $this->oauth = $this->refresh();
    $this->headersObj->XSPUSER = $this->oauth . $this->fingerprint;
    $payload = $http->get($this->headersObj, $url);
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

  if($this->printToConsole){
    var_dump("generate apple pay", $url);
  }
  $http = new HttpClient();
  $this->headersObj->XSPUSER = $this->oauth . $this->headersObj->XSPUSER;
  $payload =  $http->patch($this->headersObj, $url, $body , $userid);

  while (is_string($payload)){

    if($this->printToConsole){
      var_dump("oauth is invalid");
    }
    $this->oauth = $payload;
    $payload =  $http->patch($this->headersObj, $url, $body , $userid);
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

function generateUBOForm($entitydoc){
  $userid = $this->id;
  $url = $this->base_url . 'users/' . $userid .'/ubo';

  if($this->printToConsole){
    var_dump("generate UBO FORM url", $url);
  }

  $http = new HttpClient();
  $this->headersObj->XSPUSER = $this->oauth . $this->headersObj->XSPUSER;
  $payload = $http->patch($this->headersObj, $url, $entitydoc, $userid);

  return $payload;
}

function deleteNode($nodeID){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeID;

  if($this->printToConsole){
    var_dump("delete node url", $url);
  }

  $http = new HttpClient();
  $this->headersObj->XSPUSER = $this->oauth . $this->headersObj->XSPUSER;
  $payload =  $http->delete($this->headersObj, $url, $userid);

  //var_dump("delete request", $payload);

  while (is_string($payload)){

    if($this->printToConsole){
      var_dump("oauth is expired");
    }    $this->oauth = $payload;

    $payload =  $http->patch($this->headersObj, $url, $userid);
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

  return $payload;
}

function verifyMicroDeposit($nodeid, $micro){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid;

  if($this->printToConsole){
    var_dump("verify micro deposit", $url);
  }

  $http = new HttpClient();
  $this->headersObj->XSPUSER = $this->oauth . $this->headersObj->XSPUSER;
  $payload =  $http->patch($this->headersObj, $url, $micro , $userid);
  while (is_string($payload)){

    if($this->printToConsole){
      var_dump("oauth error");
    }

    $this->oauth = $payload;
    $payload =  $http->patch($this->headersObj, $url, $micro , $userid);
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

function shipDebitCard($nodeid, $body){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid . '?ship=YES';
  if($this->printToConsole){

    var_dump("shipDebitCard()", $url);
  }
  $http = new HttpClient();
  $this->headersObj->XSPUSER = $this->oauth . $this->headersObj->XSPUSER;
  $payload =  $http->patch($this->headersObj, $url, $body , $userid);
  //var_dump("micro", $payload);
  while (is_string($payload)){
    $this->oauth = $payload;
    $payload =  $http->patch($this->headersObj, $url, $body , $userid);
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

function reinitiateMicrodeposits($nodeid, $micro){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid . '?resend_micro=YES';;

  if($this->printToConsole){
    var_dump("reinitiateMicrodeposits()", $url);
  }

  $http = new HttpClient();
  $this->headersObj->XSPUSER = $this->oauth . $this->headersObj->XSPUSER;
  $payload =  $http->patch($this->headersObj, $url, $micro , $userid);
  //var_dump("micro", $payload);
  while (is_string($payload)){
    var_dump("yeah we have an oauth error!");
    $this->oauth = $payload;
    $payload =  $http->patch($this->headersObj, $url, $micro , $userid);
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

function resetDebitCard($nodeid, $debit){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid . '?reset=YES';;

  if($this->printToConsole){
    var_dump("resetDebitCard()", $url);
  }

  $http = new HttpClient();
  $this->headersObj->XSPUSER = $this->oauth . $this->headersObj->XSPUSER;
  $payload =  $http->patch($this->headersObj, $url, $debit , $userid);
  //var_dump("micro", $payload);
  while (is_string($payload)){
    var_dump("yeah we have an oauth error!");
    $this->oauth = $payload;
    $payload =  $http->patch($this->headersObj, $url, $debit , $userid);
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

  $nodeType = $payload->type;
  $newNode = new Node($payload, $this->id, $nodeid, $nodeType);
  return $newNode;
}

function getTransaction($nodeid, $transid){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid  . "/" . "trans/" . $transid;

  if($this->printToConsole){
    var_dump("getTransaction()", $url);
  }

  $http = new HttpClient();
  $this->headersObj->XSPUSER = $this->oauth . $this->headersObj->XSPUSER;
  $payload =  $http->get($this->headersObj, $url);


  while (is_string($payload)){
    var_dump("yeah we have an oauth error!");
    $this->oauth = $payload;
    $payload =  $http->get($this->headersObj, $url);
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

//http code 405: "Method POST is not allowed. Allowed methods are ['GET', 'PATCH', 'DELETE']"
function createTransaction($nodeid, $body){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/" . $nodeid . "/" . "trans";

  if($this->printToConsole){
    var_dump("createTransaction()", $url);
  }

  $http = new HttpClient();
  $this->headersObj->XSPUSER = $this->oauth . $this->headersObj->XSPUSER;
  $payload =  $http->post($this->headersObj, $url, $body);

  $transid = $payload->_id;

  $trans = new Transaction($transid, $payload);

  return $trans;
}

function triggerDummyTransaction($nodeid, $is_credit=null){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid  . "/" . "dummy-tran";
  if($is_credit){
    $path = '?is_credit=' . $is_credit;
  }
  $url = $url . $path;

  if($this->printToConsole){
    var_dump("triggerDummyTransaction()", $url);
  }
  $http = new HttpClient();
  $this->headersObj->XSPUSER = $this->oauth . $this->headersObj->XSPUSER;
  $payload = $http->get($this->headersObj, $url);
  while (is_string($payload)){
    if($this->printToConsole){
    var_dump("yeah we have an oauth error!");
    }
    $this->oauth = $payload;
    $payload =  $http->get($this->headersObj, $url );
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

function commentOnStatus($nodeid, $transid, $body){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid  . "/" . "trans/" . $transid;

  if($this->printToConsole){
    var_dump("commentOnStatus()", $url);
  }

  $http = new HttpClient();
  $this->headersObj->XSPUSER = $this->oauth . $this->headersObj->XSPUSER;
  $payload =  $http->patch($this->headersObj, $url, $body, $userid);

  while (is_string($payload)){

    if($this->printToConsole){
    var_dump("yeah we have an oauth error!");
    }
    $this->oauth = $payload;
    $payload =  $http->get($this->headersObj, $url);
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

function disputeCardTransaction($nodeid, $transid, $body){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid  . "/" . "trans/" . $transid . "/dispute";
  if($this->printToConsole){
    var_dump("disputeCardTransaction()", $url);
  }
  $http = new HttpClient();
  $this->headersObj->XSPUSER = $this->oauth . $this->headersObj->XSPUSER;
  $payload =  $http->patch($this->headersObj, $url, $body, $userid);

  while (is_string($payload)){
    if($this->printToConsole){
    var_dump("yeah we have an oauth error!");
    }    $this->oauth = $payload;
    $payload =  $http->get($this->headersObj, $url , $userid);
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

function deleteTransaction($nodeid, $transid){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid  . "/" . "trans/" . $transid;
  if($this->printToConsole){
    var_dump("deleteTransaction()", $url);
  }
  $http = new HttpClient();
  $this->headersObj->XSPUSER = $this->oauth . $this->headersObj->XSPUSER;
  $payload =  $http->delete($this->headersObj, $url, $userid);

  while (is_string($payload)){
    if($this->printToConsole){
    var_dump("yeah we have an oauth error!");
    }    $this->oauth = $payload;
    $payload =  $http->delete($this->headersObj, $url , $userid);
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
function createSubnet($nodeid, $body){

  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid . '/subnets';
  if($this->printToConsole){
    var_dump("createSubnet()", $url);
  }
  $http = new HttpClient();
  $this->headersObj->XSPUSER = $this->oauth . $this->headersObj->XSPUSER;
  $payload =  $http->post($this->headersObj, $url, $body);
  //var_dump("micro", $payload);
  while (is_string($payload)){
    if($this->printToConsole){
    var_dump("yeah we have an oauth error!");
    }
    $this->oauth = $payload;
    $payload =  $http->post($this->headersObj, $url, $body);
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
  $subnetid = $payload->_id;
  $subnet = new Subnet($nodeid, $subnetid, $userid, $payload );

  return $subent;
}

function getSubnet($nodeid, $subnetid){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid . '/subnets' . '/' . $subnetid;
  if($this->printToConsole){
    var_dump("getSubnet()", $url);
  }
  $http = new HttpClient();
  $this->headersObj->XSPUSER = $this->oauth . $this->headersObj->XSPUSER;
  $payload =  $http->get($this->headersObj, $url , $userid);
  //var_dump("micro", $payload);
  while (is_string($payload)){
    if($this->printToConsole){
    var_dump("yeah we have an oauth error!");
    }
    $this->oauth = $payload;
    $payload =  $http->get($this->headersObj, $url );
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

//Per_page must be pulled from the options param
function getSubnets($nodeid, $page=null, $per_page=null){
  $userid = $this->id;
  $url = $this->base_url . "users/" . $userid  . "/" . "nodes/"  . $nodeid . '/subnets';
  if($this->printToConsole){
    var_dump("getSubnets()", $url);
  }
  if($page){
    $path = $path . '?page=' . $page;
    if($per_page){
      $path = $path . '&per_page=' . $per_page;
    }
  }elseif($per_page){
    $path = $path . '?per_page=' . $per_page;
  }

  $url = $url . $path;
  var_dump("subnet url", $url);

  $http = new HttpClient();
  $this->headersObj->XSPUSER = $this->oauth . $this->headersObj->XSPUSER;
  $payload =  $http->get($this->headersObj, $url );
  //var_dump("micro", $payload);
  while (is_string($payload)){
    if($this->printToConsole){
    var_dump("yeah we have an oauth error!");
    }
    $this->oauth = $payload;
    $payload =  $http->get($this->headersObj, $url);
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

function registerNewFingerPrint($obj){
  $userid = $this->id;
  $http = new HttpClient();
  $regfingerprinturl = $this->base_url . "oauth/" . $userid;
  if($this->printToConsole){
    var_dump("registerNewFingerPrint() obj", $obj);
  }
  $fingerPrintObj = $http->post($this->headersObj, $regfingerprinturl, $obj);
  var_dump("fp", $fingerPrintObj);
  return $fingerPrintObj;
}


} // class Users


?>
