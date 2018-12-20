 <?php
  class Subscription
  {
      public $id;
      public $url;
      public $body;
      
      function __construct($id, $url, $body){
        $this->id = $id;
        $this->url = $url;
        $this->body = $body;
      }
  }
 ?>
