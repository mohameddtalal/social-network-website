<?php
require_once(__DIR__ . "/../../config/config.php");
require_once(__DIR__ . "/../classes/User.php");
require_once(__DIR__ . "/../classes/Message.php");

$limit=7; //number of messages to load
 
$message= new Message($con,$_REQUEST['userLoggedIn']);  //come from request of ajax

echo $message->getConvosDropdown($_REQUEST,$limit);


?>