<?php
require_once(__DIR__ . "/../../config/config.php");
require_once(__DIR__ . "/../classes/User.php");
require_once(__DIR__ . "/../classes/Notification.php");

$limit=7; //number of messages to load
 
$notification= new Notification($con,$_REQUEST['userLoggedIn']);  //come from request of ajax

echo $notification->getNotifications($_REQUEST,$limit);

?>