<?php
class SynapseException extends Exception {

  public function __construct($httpcode, $errormessage, $errorcode, $response) {

      $this->$http_code = $http_code;
      $this->$error_message = $error_message;
      $this->$error_code = $error_code;
      //$this->$response = $response;

      // var_dump("resp", $this->$response);
      // var_dump("error_code", $this->$error_code);
      // var_dump("error_message", $this->$error_message);
      // var_dump("http_code", $this->$http_code);

      //parent::__construct($error_message);
  }

}


?>
