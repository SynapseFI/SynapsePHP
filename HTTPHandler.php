<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;




    function getOauthUserRequests($headersObj, $refreshtoken, $userid){
      $request_headers = array();
      $request_headers[] = 'X-SP-GATEWAY:' . $headersObj->XSPGATEWAY;
      $request_headers[] = 'X-SP-USER-IP:' . $headersObj->XSPUSERIP;
      $request_headers[] = 'X-SP-USER:' . $headersObj->XSPUSER;
      $request_headers[] = 'Content-Type:' . $headersObj->ContentType;

      $base = "https://uat-api.synapsefi.com/v3.1/oauth/";
      $url = $base . $userid;
      $data = (object) [
        'refresh_token' => $refreshtoken
      ];


      $data_string = json_encode($data);
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $result = curl_exec($ch);
      $obj = json_decode($result);

      return $obj->oauth_key;
    }

    function createUserRequest($headersObj, $logins_object, $phoneNumbers_array = null, $legalnames_array = null) {

      $request_headers = array();
      $request_headers[] = 'X-SP-GATEWAY:' . $headersObj->XSPGATEWAY;
      $request_headers[] = 'X-SP-USER-IP:' . $headersObj->XSPUSERIP;
      $request_headers[] = 'X-SP-USER:' . $headersObj->XSPUSER;
      $request_headers[] = 'Content-Type:' . $headersObj->ContentType;

      $url = "https://uat-api.synapsefi.com/v3.1/users";

      $logins_array = array();
      $logins_array[] = $logins_object;

      $data = array("logins"=>$logins_array, "phone_numbers"=>$phoneNumbers_array, "legal_names" => $legalnames_array);
      $data_string = json_encode($data);
      $ch = curl_init($url);

      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      //execute post
      $result = curl_exec($ch);
      $obj = json_decode($result);

      return $obj;
    }

    //https://uat-api.synapsefi.com/v3.1/users/:user_id?full_deydrate=yes; ??
    function getUserRequest($headersObj, $userid, $options = null){

      $optionsArray = array('page', 'per_page', 'query', 'show_refresh_tokens', 'type', 'full_dehydrate');
      $request_headers = array();
      $request_headers[] = 'X-SP-GATEWAY:' . $headersObj->XSPGATEWAY;
      $request_headers[] = 'X-SP-USER-IP:' . $headersObj->XSPUSERIP;
      $request_headers[] = 'X-SP-USER:' . $headersObj->XSPUSER;
      $request_headers[] = 'Content-Type:' . $headersObj->ContentType;
      $url = "https://uat-api.synapsefi.com/v3.1/users/";

        if(isset($options)){
          foreach ($options as $key => $value) {
            if (in_array($key, $optionsArray )){
                if ($key == 'full_dehydrate'){
                  $url = $url . $userid . '?full_dehydrate=' . $value;
                }
            }//innerif
          }//foreach
        }//outerif
        else{
          $url = $url . $userid;
        }

      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
      $response_body = curl_exec($ch);
      $obj = json_decode($response_body);
      //var_dump("THEOBJ:",$obj);
      return $obj;
    }

    //$headersObj, $query = null, $page = null, $per_page = null, $refreshtoken=null ,$fulldehydrate = null
    function getAllUserRequest($headersObj, $options = null){

      $optionsArray = array('page', 'per_page', 'query', 'show_refresh_tokens', 'type', 'full_dehydrate');

      $request_headers = array();
      $request_headers[] = 'X-SP-GATEWAY:' . $headersObj->XSPGATEWAY;
      $request_headers[] = 'X-SP-USER-IP:' . $headersObj->XSPUSERIP;
      $request_headers[] = 'X-SP-USER:' . $headersObj->XSPUSER;
      $request_headers[] = 'Content-Type:' . $headersObj->ContentType;


      $base = "https://uat-api.synapsefi.com/v3.1/users";


      if (isset($options)){
        foreach ($options as $key => $value) {
          if (in_array($key, $optionsArray )){
              if ($key == 'query')
                  $url = $base . '?query=' . $value;

              if ($key == 'page'){
                      $url = $url . '&amp;page=' . $value;
              }
              if ($key == 'per_page'){
                      $url = $url . '&amp;per_page=' . $value;
              }
              if ($key == 'show_refresh_tokens'){
                      $url = $url . '&amp;show_refresh_tokens=' . $value;
              }

          }//innerif
        }//foreach
      }//outerif
      else{$url = $base;}

      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response_body = curl_exec($ch);
      $obj = json_decode($response_body);
      return $obj;
    }

    function getAllClientTransactionsRequest($headersObj, $options = null){
      $optionsArray = array('page', 'per_page', 'query', 'show_refresh_tokens', 'type', 'full_dehydrate');

      $request_headers = array();
      $request_headers[] = 'X-SP-GATEWAY:' . $headersObj->XSPGATEWAY;
      $request_headers[] = 'X-SP-USER-IP:' . $headersObj->XSPUSERIP;
      $request_headers[] = 'X-SP-USER:' . $headersObj->XSPUSER;
      $request_headers[] = 'Content-Type:' . $headersObj->ContentType;

      $url = "https://uat-api.synapsefi.com/v3.1/trans";

        if (isset($options)) {
          foreach ($options as $key => $value) {
            if (in_array($key, $optionsArray )){

                if ($key == 'page'){
                    $url = $url . '?page=' . $value;
                }
                if ($key == 'per_page'){
                    $url = $url . '?per_page=' . $value;
                }
            }//innerif
          }//foreach
        }//outerif

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response_body = curl_exec($ch);
        $obj = json_decode($response_body);
        return $obj;

    }//getAllClientTransactionsRequest

    // OAUTH key is needed
    function getAllUserTransactionsRequests($headersObj, $oauthkey, $userid, $options){
      $optionsArray = array('page', 'per_page', 'query', 'show_refresh_tokens', 'type', 'full_dehydrate');

      //retrieve the oauthkey
      $xspuser = 'X-SP-USER:' . $oauthkey . $headersObj->XSPUSER;
      $request_headers = array();
      $request_headers[] = 'X-SP-USER-IP:' . $headersObj->XSPUSERIP;
      $request_headers[] = 'X-SP-USER:' . $oauthkey . $headersObj->XSPUSER;
      $url = "https://uat-api.synapsefi.com/v3.1/users/" . $userid . "/trans";

      if (isset($options)) {
        foreach ($options as $key => $value) {
          if (in_array($key, $optionsArray )){

              if ($key == 'page'){
                  $url = $url . '?page=' . $value;
              }
              if ($key == 'per_page'){
                  $url = $url . '?per_page=' . $value;
              }
          }//innerif
        }//foreach
      }//outerif

      $response_body = curl_exec($ch);
      $obj = json_decode($response_body);
      return $obj;

    }

    function getAllPlatformNodesRequests($headersObj){
      $request_headers = array();
      $request_headers[] = 'X-SP-GATEWAY:' . $headersObj->XSPGATEWAY;
      $request_headers[] = 'Content-Type:' . $headersObj->ContentType;
      $url = "https://uat-api.synapsefi.com/v3.1/nodes";
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response_body = curl_exec($ch);

      $obj = json_decode($response_body);
      return $obj;
    }

    function getAllNodesRequests($headersObj, $userid, $oauthkey, $options = null){
      $optionsArray = array('page', 'per_page', 'query', 'show_refresh_tokens', 'type', 'full_dehydrate');
      $request_headers = array();
      $request_headers[] = 'X-SP-USER-IP:' . $headersObj->XSPUSERIP;
      $request_headers[] = 'X-SP-USER:' . $oauthkey . $headersObj->XSPUSER;
      $request_headers[] = 'Content-Type:' . $headersObj->ContentType;

      $url = "https://uat-api.synapsefi.com/v3.1/users/" . $userid . "/nodes";

      if (isset($options)) {
        foreach ($options as $key => $value) {
          if (in_array($key, $optionsArray )){

              if ($key == 'page'){
                  $url = $url . '?page=' . $value;
              }
              if ($key == 'per_page'){
                  $url = $url . '?per_page=' . $value;
              }
              if ($key == 'type'){
                  $url = $url . '?type=' . $value;
              }
          }//innerif
        }//foreach
      }//outerif

      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response_body = curl_exec($ch);

      $obj = json_decode($response_body);
      //var_dump("convert",$obj);
      $response_code = $obj->http_code;

      if ($response_code == '401'){
        echo('yes the oauthkey has expired');
        $newOuathkey = refresh($headersObj, $userid);
        $obj = getAllNodesRequests($headersObj, $userid, $newOuathkey, $options);

      }
      else{
        echo('youre validated');
      //var_dump('return', $obj);
        }

      return $obj;
    }


    function refresh($headersObj, $userid){

      $userObj = getUserRequest($headersObj, $userid, $fulldehydrate = null);
      $refreshtoken = $userObj->refresh_token;
      $oauthkey = getOauthUserRequests($headersObj, $refreshtoken, $userid);
      return $oauthkey;
    }

    function getInstitutionRequests($headersObj){
      $request_headers = array();
      $request_headers[] = 'X-SP-USER-IP:' . $headersObj->XSPUSERIP;
      //$request_headers[] = 'X-SP-USER:' . $oauthkey . $headersObj->XSPUSER;
      $request_headers[] = 'X-SP-USER:'  . $headersObj->XSPUSER;
      $request_headers[] = 'Content-Type:' . $headersObj->ContentType;

      $url = "https://uat-api.synapsefi.com/v3.1/institutions";

      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response_body = curl_exec($ch);
      $obj = json_decode($response_body);
      return $obj;
    }

    function getAllSubscriptionRequests($headersObj){
      $request_headers = array();
      $request_headers[] = 'X-SP-GATEWAY:' . $headersObj->XSPGATEWAY;

      $url = "https://uat-api.synapsefi.com/v3.1/subscriptions";

      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response_body = curl_exec($ch);
      $obj = json_decode($response_body);

      return $obj;

    }

    function getSubscriptionRequest($headersObj, $subscriptionID){
      $request_headers = array();
      $request_headers[] = 'X-SP-GATEWAY:' . $headersObj->XSPGATEWAY;
      $url = "https://uat-api.synapsefi.com/v3.1/subscriptions/" . $subscriptionID;

      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response_body = curl_exec($ch);
      $obj = json_decode($response_body);


      return $obj;
    }

    function createSubscriptionRequest($headersObj, $data){

      $request_headers = array();
      $request_headers[] = 'X-SP-GATEWAY:' . $headersObj->XSPGATEWAY;
      $request_headers[] = 'Content-Type:' . $headersObj->ContentType;
      if($headersObj->XSPIDEMPOTENCYKEY){
        $request_headers[] = 'X-SP-IDEMPOTENCY-KEY:' . $headersObj->XSPIDEMPOTENCYKEY;
      }

      $url = "https://uat-api.synapsefi.com/v3.1/subscriptions";

      $data_string = json_encode($data);

      $ch = curl_init($url);

      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      //execute post
      $result = curl_exec($ch);
      $obj = json_decode($result);


      return $obj;
    }

    function updateSubscriptionRequest($headersObj, $data, $subscriptionID){
      $request_headers = array();
      $request_headers[] = 'X-SP-GATEWAY:' . $headersObj->XSPGATEWAY;
      $request_headers[] = 'Content-Type:' . $headersObj->ContentType;
      $url = "https://uat-api.synapsefi.com/v3.1/subscriptions/" . $subscriptionID;


      $ch = curl_init($url);
      $data_string = json_encode($data);

      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
      curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response_body = curl_exec($ch);
      $obj = json_decode($response_body);

      return $obj;
    }

    function updateUserRequest($headersObj, $docbody, $oauthkey, $userid){

      $request_headers = array();
      $request_headers[] = 'X-SP-GATEWAY:' . $headersObj->XSPGATEWAY;
      $request_headers[] = 'X-SP-USER-IP:' . $headersObj->XSPUSERIP;
      $request_headers[] = 'X-SP-USER:' . $headersObj->XSPUSER;
      $request_headers[] = 'Content-Type:' . "application/json";

      $url = "https://uat-api.synapsefi.com/v3.1/users/" . $userid;

      $data_string = json_encode($docbody);
      $ch = curl_init($url);

      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
      curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      //execute post
      $result = curl_exec($ch);
      $response_body = curl_exec($ch);
      $obj = json_decode($response_body);
      $response_code = $obj->http_code;

      if ($response_code == '401'){
        return $response_code;
      }
      return $obj;
    }


    function updateDocumentsRequest($headersObj, $docbody, $oauthkey, $userid){

      $request_headers = array();
      $request_headers[] = 'X-SP-GATEWAY:' . $headersObj->XSPGATEWAY;
      $request_headers[] = 'X-SP-USER-IP:' . $headersObj->XSPUSERIP;
      $request_headers[] = 'X-SP-USER:' . $headersObj->XSPUSER;
      //$request_headers[] = 'X-SP-USER:' . $oauthkey . $headersObj->XSPUSER;
      $request_headers[] = 'Content-Type:' . "application/json";

      $url = "https://uat-api.synapsefi.com/v3.1/users/" . $userid;

      $data_string = json_encode($docbody);



      $ch = curl_init($url);

      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
      curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      //execute post
      $result = curl_exec($ch);
      $response_body = curl_exec($ch);
      $obj = json_decode($response_body);

      $response_code = $obj->http_code;
      if ($response_code == '401'){
        echo 'error';
      }
      return $obj;
    }

    function addNewDocumentsRequest($headersObj, $docbody, $oauthkey, $userID){
      //var_dump("oauth", $oauthkey);

      $request_headers = array();
      $request_headers[] = 'X-SP-GATEWAY:' . $headersObj->XSPGATEWAY;
      $request_headers[] = 'X-SP-USER-IP:' . $headersObj->XSPUSERIP;
      //$request_headers[] = 'X-SP-USER:' . $oauthkey . $headersObj->XSPUSER;
      $request_headers[] = 'X-SP-USER:' . $headersObj->XSPUSER;
      $request_headers[] = 'Content-Type:' . "application/json";
      $url = "https://uat-api.synapsefi.com/v3.1/users/" . $userID;

      $data_string = json_encode($docbody);
      $ch = curl_init($url);

      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
      curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      //execute post
      $result = curl_exec($ch);
      $response_body = curl_exec($ch);
      $obj = json_decode($response_body);
      $response_code = $obj->http_code;

      if ($response_code == '401'){
        echo 'error';
      }
      return $obj;
    }

    function createDepositAccountsRequest($headersObj, $userid, $oauth, $deposit_account_object){

      $request_headers = array();
      $request_headers[] = 'X-SP-USER-IP:' . $headersObj->XSPUSERIP;
      $request_headers[] = 'X-SP-USER:' . $oauth . $headersObj->XSPUSER;
      $request_headers[] = 'Content-Type:' . $headersObj->ContentType;


      $url = "https://uat-api.synapsefi.com/v3.1/users/" . $userid . "/nodes";

      $data_string = json_encode($deposit_account_object);
      $ch = curl_init($url);

      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response_body = curl_exec($ch);
      $obj = json_decode($response_body);

      return $obj;
    }

    function getNodeRequests($headersObj, $userID, $nodeID, $oauthkey){

      $url = "https://uat-api.synapsefi.com/v3.1/users/" .$userID . "/nodes/" . $nodeID;

      $request_headers = array();
      $request_headers[] = 'X-SP-USER-IP:' . $headersObj->XSPUSERIP;
      $request_headers[] = 'X-SP-USER:' . $oauthkey . $headersObj->XSPUSER;
      $request_headers[] = 'Content-Type:' . $headersObj->ContentType;

      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
      curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $response_body = curl_exec($ch);
      $obj = json_decode($response_body);

      $response_code = $obj->http_code;

      if ($response_code == '401'){
        echo('yes the oauthkey has expired');
        $newOuathkey = refresh($headersObj, $userID);
        $obj = getNodeRequests($headersObj, $userID, $nodeID, $newOuathkey);
      }
      else{
        echo('verified!');
      }
      return $obj;
    }

    function getPublicKeyRequests($headersObj, $scope = null){
      if($scope){
      $url = "https://uat-api.synapsefi.com/v3.1/client" . "?" . 'issue_public_key=YES'  . '&amp;scope=' . $scope . ' HTTP/1.1';
      }
      else{
        $url = "https://uat-api.synapsefi.com/v3.1/client" . "?" . 'issue_public_key=YES';
      }
      var_dump("url",$url);
      $request_headers = array();
      $request_headers[] = 'X-SP-GATEWAY:' . $headersObj->XSPGATEWAY;
      $request_headers[] = 'Content-Type:' . $headersObj->ContentType;
      var_dump("request headers",  $request_headers);
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
      curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response_body = curl_exec($ch);
      var_dump("resp body",$response_body);
      $obj = json_decode($response_body);
      return $obj;
    }

?>
