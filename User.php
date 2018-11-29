<?php
include 'Node.php';
//include 'HTTPHandler.php';

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
//function createDepositAccounts($userid, $deposit_account_object){

function checkForErrors($http_code, $error_message){
  if ($http_code == '202'){
    throw new Exception("Accepted, but not final response");
  }
  if ($http_code == '400'){
    throw new Exception("Bad request to API. Missing a field or an invalid field");
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

function createDepositAccounts($deposit_account_object){
  $nodeType = $deposit_account_object->type;
  $payload = createDepositAccountsRequest($this->headersObj, $this->id, $this->oauth,  $deposit_account_object );

  try{
    $this->checkForErrors($payload->http_code, $payload->error);
  }
  catch(Exception $e){
    //echo "Message: " . $e->getMessage();
    return $e->getMessage();
  }


   $nodeID = $payload->nodes[0]->_id;
   $userID = $this->id;
   $newNode = new Node($payload, $userID, $nodeID, $nodeType );
   return $newNode;
}

function getNode($nodeID){

   $payload = getNodeRequests($this->headersObj, $this->id, $nodeID, $this->oauth);

   try{
     $this->checkForErrors($payload->http_code, $payload->error);
   }
   catch(Exception $e){
     //echo "Message: " . $e->getMessage();
     return $e->getMessage();
   }

   $nodeType = $payload->type;
   $newNode = new Node($payload, $this->id, $nodeID, $nodeType);

   return $newNode;
}

function updateUser($updateuserbody){

  $userid= $this->id;
  $oauthkey = $this->oauth;
  $updatedocresponse = updateUserRequest($this->headersObj, $updateuserbody, $oauthkey, $userid );
  try{
    $this->checkForErrors($updatedocresponse->http_code, $updatedocresponse->error);
  }
  catch(Exception $e){
    //echo "Message: " . $e->getMessage();
    return $e->getMessage();
  }

  return $updatedocresponse;
}

function updateDocuments($updatedocsbody){

  $userid= $this->id;
  $oauthkey = $this->oauth;


  $updatedocresponse = updateDocumentsRequest($this->headersObj, $updatedocsbody, $oauthkey, $userid );

  try{
    $this->checkForErrors($updatedocresponse->http_code, $updatedocresponse->error);
  }
  catch(Exception $e){
    //echo "Message: " . $e->getMessage();
    return $e->getMessage();
  }

  return $updatedocresponse;
}

function addUserKYC($docbody){

    $oauthkey = $this->oauth;
    $userid= $this->id;
    $docresponse = addNewDocumentsRequest($this->headersObj, $docbody, $oauthkey, $userid );
    try{
      $this->checkForErrors($docresponse->http_code, $docresponse->error);
    }
    catch(Exception $e){
      //echo "Message: " . $e->getMessage();
      return $e->getMessage();
    }

    return $docresponse;
}

} // class Users


?>
