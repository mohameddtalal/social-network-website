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
            <?php
                //unread messages 
                $messages= new Message($con,$userLoggedIn);
                $num_messages=$messages->getUnreadNumber();
            ?>
            <a href="<?php echo $userLoggedIn ?>">
                <?php
                echo $user['first_name'];
                ?>
            </a>
            <a href="index.php">
                <i class="fa fa-home fa-lg"></i>
            </a>
            <a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>','message')">
                <i class="fa fa-envelope fa-lg"></i>
                <?php
                if ($num_messages >0)
                 echo '<span class="notification_badge" id="unread_message">'.$num_messages .'</span> ';
                ?>
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
        <div class="dropdown_data_window" style="height:0px; border:none;">
            <input type="hidden" id="dropdown_data_type" value="">

        </div>
    </div>
<script>
        var userLoggedIn='<?php echo $userLoggedIn; ?>'
        $(document).ready(function(){
  
            $('.dropdown_data_window').scroll(function(){    //when page not equal 1
                var inner_height= $('.dropdown_data_window').innerHeight();  //div containing data
                var scroll_top=$('.dropdown_data_window').scrollTop();
                var page=$('.dropdown_data_window').find('.nextPageDropdownData').val();
                var noMoreData = $('.dropdown_data_window').find('.noMoreDropdownData').val();

                if((scroll_top+inner_height >= $('.dropdown_data_window')[0] .scrollHeight)&& noMoreData=='false'){
                        var pageName; //holds name of page to send ajax request to
                        var type=$('#dropdown_data_type').val();

                        if(type == 'notification')
                            pageName="ajax_load_notifications.php";
                        else if(type='message')
                            pageName="ajax_load_messages.php";


                        var ajaxReq= $.ajax({
                            url:"includes/handlers/" +pageName, 
                            type:"POST",
                            data:"page=" + page + "&userLoggedIn=" + userLoggedIn,
                            cache:false,

                            success:function(response){
                                $('.dropdown_data_window').find('.nextPageDropdownData').remove(); //removes current .nextPage
                                $('.dropdown_data_window').find('.noMoreDropdownData').remove(); //removes current .nextPage

                                $('.dropdown_data_window').append(response);
                            }
                        });
                } //end if
                return false;
            });// end  window . scroll function
        });

    </script>


    <div class="wrapper">
        

