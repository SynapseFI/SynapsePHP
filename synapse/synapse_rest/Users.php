<?php

class Users
{

  public $list_of_users;
  public $users_count;
  public $limit;
  public $page_count;
  public $page;
 function __construct($listOfUsers, $numUsers, $page, $page_count, $limit) {

    $this->list_of_users = $listOfUsers;
    $this->users_count = $numUsers;
    $this->limit = $limit;
    $this->page_count = $page_count;
    $this->page = $page;
 }


} // class Users
?>
