<?php

class Users
{


 function __construct($allusersobj) {



    $this->$list_of_users = $allusersobj->list;
    $this->$users_count = $allusersobj->userscount;

    // $this->$limit = $limit;
    // $this->$page_count = $page_count;
    // $this->$page = $page;
 }


} // class Users
?>
