<?php
require_once(__DIR__ . "/../../config/config.php");
require_once(__DIR__ . "/../classes/User.php");
require_once(__DIR__ . "/../classes/Post.php");

$limit=10; //number of posts to loaded per call

$posts = new Post($con, $_REQUEST['userLoggedIn']);
$posts->loadProfilePosts($_REQUEST,$limit);



?>