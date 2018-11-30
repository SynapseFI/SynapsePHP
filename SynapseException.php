<?php
class SynapseException{

    public $http_code;
    public $error_message;
    public $error_code;

    function __construct($httpcode, $errormessage, $errorcode, $response) {
      // var_dump("pre error_code", $errorcode);
      // var_dump("pre error_message", $errormessage);
      // var_dump("pre http_code", $httpcode);

      $this->$http_code = $httpcode;
      $this->$error_message = $errormessage;
      $this->$error_code = $errorcode;
      //$this->$response = $response;
      // var_dump("error_code", $this->$error_code);
      // var_dump("error_message", $this->$error_message);
      // var_dump("http_code", $this->$http_code);
  }

}


?>
