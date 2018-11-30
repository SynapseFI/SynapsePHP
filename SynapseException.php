<?php
class SynapseException extends Exception{

    public $http_code;
    public $error_message;
    public $error_code;
    public $response;

    function __construct($httpcode, $errormessage, $errorcode, $response) {
      $this->http_code = $httpcode;
      $this->error_message = $errormessage;
      $this->error_code = $errorcode;
      $this->response = $response;
      parent::__construct($errormessage);
  }

}


?>
