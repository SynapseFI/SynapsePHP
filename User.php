<?php
include 'Node.php';
//include 'HTTPHandler.php';
//include 'SynapseException.php';

class User
{

function __construct($userObj) {
   $this->oauth = $userObj->oauth;
   $this->id = $userObj->id;
   $this->payload =  $userObj->payload;

   $this->headersObj = (object) [
     'XSPGATEWAY' => $userObj->XSPGATEWAY,
     'XSPUSERIP' => $userObj->XSPUSERIP,
     'XSPUSER' => $userObj->XSPUSER,
     'ContentType' => $userObj->ContentType
   ];
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


function createDepositAccounts($deposit_account_object){

  $payload = createDepositAccountsRequest($this->headersObj,$this->id,$this->oauth,$deposit_account_object);
  $errormessage = $payload->error->en;
  $errorcode = $payload->error_code;
  $httpcode= $payload->http_code;
  try{
    $this->checkForErrors($httpcode, $errormessage, $errorcode, $payload);
  }
  catch(SynapseException $e){
    return $e;
  }
 $nodeType = $deposit_account_object->type;
 $nodeID = $payload->nodes[0]->_id;
 $userID = $this->id;
 $newNode = new Node($payload, $userID, $nodeID, $nodeType );
 return $newNode;

}

function getNode($nodeID){
   $payload = getNodeRequests($this->headersObj, $this->id, $nodeID, $this->oauth);
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
  $updatedocresponse = updateUserRequest($this->headersObj, $updateuserbody, $oauthkey, $userid );

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

} // class Users


?>
