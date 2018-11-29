<?php

class Users
{
 var $payload;
 var $pagelimit;
 var $pagecount;

 function __construct($users_count, $limit ,$page_count, $page, $list_of_users) {
    $this->$users_count = $users_count;
    $this->$limit = $limit;
    $this->$page_count = $page_count;
    $this->$page = $page;
    $this->$list_of_users = $list_of_users;
 }




} // class Users




?>
