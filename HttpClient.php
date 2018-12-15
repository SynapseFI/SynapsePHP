<?php
class HttpClient{

  function __construct() {
    // $this->clientId = $headers->client_id;
    // $this->clientSecret = $headers->client_secret;
    // $this->fingerPrint = $headers->fingerprint;
    // $this->ipAddress = $headers->ip_address;
    // $this->base_url = $headers->base_url;
  }

  function get($headersObj, $url , $options = null){
    $optionsArray = array('page', 'per_page', 'query', 'show_refresh_tokens', 'type', 'full_dehydrate');
    $request_headers = array();
    $request_headers[] = 'X-SP-GATEWAY:' . $headersObj->XSPGATEWAY;
    $request_headers[] = 'X-SP-USER-IP:' . $headersObj->XSPUSERIP;
    $request_headers[] = 'X-SP-USER:' . $headersObj->XSPUSER;
    $request_headers[] = 'Content-Type:' . $headersObj->ContentType;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
    $response_body = curl_exec($ch);
    $obj = json_decode($response_body);
    $response_code = $obj->http_code;
    if ($response_code == '401'){
      echo('yes the oauthkey has expired');
        // $newOuathkey = refresh($headersObj, $userid);
        return $response_code;
    }
    return $obj;
  }

  function patch($headersObj, $url , $body, $options = null){

    var_dump("body", $body);

    $optionsArray = array('page', 'per_page', 'query', 'show_refresh_tokens', 'type', 'full_dehydrate');

    $request_headers = array();
    $request_headers[] = 'X-SP-GATEWAY:' . $headersObj->XSPGATEWAY;
    $request_headers[] = 'X-SP-USER-IP:' . $headersObj->XSPUSERIP;
    $request_headers[] = 'X-SP-USER:' . $headersObj->XSPUSER;
    $request_headers[] = 'Content-Type:' . $headersObj->ContentType;

    $ch = curl_init($url);
    $data_string = json_encode($body);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response_body = curl_exec($ch);
    $obj = json_decode($response_body);
    $response_code = $obj->http_code;
    if ($response_code == '401'){
      echo('yes the oauthkey has expired');
        // $newOuathkey = refresh($headersObj, $userid);
        return $response_code;
    }

    return $obj;
  }

  function post($headersObj, $url, $body, $options = null){
    $optionsArray = array('page', 'per_page', 'query', 'show_refresh_tokens', 'type', 'full_dehydrate');

    $request_headers = array();
    $request_headers[] = 'X-SP-GATEWAY:' . $headersObj->XSPGATEWAY;
    $request_headers[] = 'X-SP-USER-IP:' . $headersObj->XSPUSERIP;
    $request_headers[] = 'X-SP-USER:' . $headersObj->XSPUSER;
    $request_headers[] = 'Content-Type:' . $headersObj->ContentType;

    if($headersObj->XSPIDEMPOTENCYKEY){
      $request_headers[] = 'X-SP-IDEMPOTENCY-KEY:' . $headersObj->XSPIDEMPOTENCYKEY;
    }


    //var_dump("headers", $request_headers);
    $data_string = json_encode($body);
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response_body = curl_exec($ch);
    $obj = json_decode($response_body);
    $response_code = $obj->http_code;

    if ($response_code == '401'){
        return $response_code;
    }
    return $obj;
  }

  function delete($headersObj, $url, $options = null){

    $optionsArray = array('page', 'per_page', 'query', 'show_refresh_tokens', 'type', 'full_dehydrate');

    $request_headers = array();
    $request_headers[] = 'X-SP-GATEWAY:' . $headersObj->XSPGATEWAY;
    $request_headers[] = 'X-SP-USER-IP:' . $headersObj->XSPUSERIP;
    $request_headers[] = 'X-SP-USER:' . $headersObj->XSPUSER;
    $request_headers[] = 'Content-Type:' . $headersObj->ContentType;

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response_body = curl_exec($ch);
    $obj = json_decode($response_body);

    $response_code = $obj->http_code;
    if ($response_code == '401'){
        return $response_code;
    }
    return $obj;
  }




}


?>
