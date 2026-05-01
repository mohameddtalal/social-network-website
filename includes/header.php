<?php
require_once("./config/config.php");
require_once("includes/classes/User.php");
require_once("includes/classes/Post.php");
require_once("includes/classes/Message.php");


if(isset($_SESSION['username'])){
    $userLoggedIn=$_SESSION['username'];
    $user_details_query=mysqli_query($con,"SELECT * FROM users WHERE username='$userLoggedIn' ");
    $user=mysqli_fetch_array($user_details_query); //can store as array to use it
}else{
    header("Location:register.php");
}
?>

<html>  
<head>
 <title>Swirlfeed</title>

   <!-- CSS first -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/jquery.Jcrop.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- JS at bottom — jQuery first, then Popper, then Bootstrap, then others -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/demo.js"></script>
    <script src="assets/js/bootbox.min.js"></script>
    <script src="assets/js/jquery.jcrop.js"></script>
    <script src="assets/js/jcrop_bits.js"></script>

</head>
<body>
    <div class="top_bar">
        <div class="logo">
            <a href="index.php">Swirlfeed!</a>
        </div>
        <nav>
            <a href="<?php echo $userLoggedIn ?>">
                <?php
                echo $user['first_name'];
                ?>
            </a>
            <a href="index.php">
                <i class="fa fa-home fa-lg"></i>
            </a>
            <a href="#">
                <i class="fa fa-envelope fa-lg"></i>
            </a>
            <a href="#">
                <i class="fa fa-bell fa-lg"></i>
            </a>
              <a href="requests.php">
                <i class="fa fa-users fa-lg"></i>
            </a>
            <a href="#">
                <i class="fa fa-cog fa-lg"></i>
            </a>
             <a href="includes/handlers/logout.php">
                <i class="fa fa-sign-out fa-lg"></i>
            </a>
        </nav>
    </div>

    <div class="wrapper">
        

