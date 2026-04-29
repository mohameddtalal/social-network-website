<?php
require_once("config/config.php");

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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>

    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
              <a href="#">
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
        

