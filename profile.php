<?php
require_once("includes/header.php");
require_once("config/config.php");
require_once("includes/classes/User.php");
require_once("includes/classes/Post.php");

$message_obj=new Message($con,$userLoggedIn);

if(isset($_GET['profile_username'])){
    $username = $_GET['profile_username'];
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
    $user_array = mysqli_fetch_array($user_details_query);

    // ✅ Add this check
    if(!$user_array){
        echo "User not found!";
        exit();
    }

    $num_friends = (substr_count($user_array['friend_array'], ",")) - 1;
}else{
    // ✅ Handle missing GET parameter
    header("Location:index.php");
    exit();
}

if(isset($_POST['remove_friend'])){
    $user= new User($con,$userLoggedIn);
    $user->removeFriend($username);
}
if(isset($_POST['add_friend'])){
    $user= new User($con,$userLoggedIn);
    $user->sendRequest($username);
}
if(isset($_POST['respond_request'])){
  header("Location: requests.php");
}

if(isset($_POST['post_message'])){
    if(isset($_POST['message_body'])){
        $body=mysqli_real_escape_string($con,$_POST['message_body']);
        $date= date("Y-m-d H:i:s");
        $message_obj->sendMessage($username,$body,$date);
    }
    $link='#profileTabs a[href="#messages_div"]';
    echo "<script>
    $(function(){
        $('". $link."').tab('show');

    });
    </script>";

}



?>
        <style type="text/css">
            .wrapper{
            margin-left:0px ;
            padding-left: 0px;
        }
        </style>

    <div class="profile_left">
        <img src="<?php echo $user_array['profile_pic']; ?>">
        <div class="profile_info">
            <p><?php echo "Posts: ".$user_array['num_posts']; ?></p>
            <p><?php echo "Likes: ".$user_array['num_likes']; ?></p>
            <p><?php echo "Friends: ". $num_friends; ?></p>
        </div>

        <form action="<?php echo $username; ?>" method="POST">
            <?php
             $profile_user_obj=new User($con,$username);
             if($profile_user_obj->isClosed()){
                header("Location:user_closed.php");
             }
             $Logged_in_user_obj=new User($con,$userLoggedIn);
             if($userLoggedIn!=$username){
                if($Logged_in_user_obj->isFriend($username)){
                    echo '<input type="submit" name="remove_friend" class="danger" value="Remove Friend"> <br> ';
                }else if($Logged_in_user_obj->didReceiveRequest($username)){
                  echo '<input type="submit" name="respond_request" class="warning" value="Respond to Request"> <br> ';

                }
                else if($Logged_in_user_obj->didSendRequest($username)){
                  echo '<input type="submit" name="" class="default" value="Request Sent"> <br> ';

                }else{
                  echo '<input type="submit" name="add_friend" class="success" value="Add friend"> <br> ';

                }
             }
             
            
            
            ?>

        </form>
        <input type="submit" class="deep_blue" data-toggle="modal" data-target="#post_form" value="Post Something" >
        <?php
        if($userLoggedIn != $username){
            echo '<div class="profile_info_bottom"> ';
             echo $Logged_in_user_obj->getMutualFriends($username)." Mutual friends";
         echo '</div>';
        }
        ?>

    </div>

    <div  class="profile_main_column column">
        <ul class="nav nav-tabs" role="tablist" id="profileTabs">
            <li role="presentation" class="active">
                <a class="nav-link active" href="#newsfeed_div" aria-controls="newsfeed_div" role="tab" data-toggle="tab">Newsfeed</a>
            </li>

            <li role="presentation">
                <a  class="nav-link " href="#messages_div"  aria-controls="messages_div" role="tab" data-toggle="tab">Messages</a>
            </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade show active" id="newsfeed_div">
                              <div class="posts_area"></div>
                            <img id="loading" src="assets/images/icons/loading.gif">
                </div>

                  <div role="tabpanel" class="tab-pane fade " id="messages_div">
                            <?php 

                        echo "<h4> You and <a href= '". $username ."'>" .$profile_user_obj->getFirstAndLastName(). "</a></h4><hr><br>";
                        echo "<div class='loaded_messages' id='scroll_messages'> ";
                        echo $message_obj->getMessages($username);
                        echo "</div>";
                    ?>



                <div class="message_post">
                    <form action="" method="POST">
                     
                        <textarea name='message_body' id='message-textarea' placeholder='Write your message ...'></textarea>
                        <input type='submit' name='post_message' class='info' id='message_submit' value='Send'>

                </form>

            </div>

            <script>
                var div = document.getElementById("scroll_messages");
                if(div){
                    div.scrollTop = div.scrollHeight;
                }
            </script>
                </div>

            </div>


    </div>


<!-- Modal -->
<div class="modal fade" id="post_form" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Post something!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <p>This will appear on user's profile page and also their newsfeed for your friends too see!</p>
        <form class="profile_post" action="" method="POST">
            <div class="form-group">
                <textarea class="form-control" name="post_body"></textarea>
                <input type="hidden" name="user_from" value="<?php echo $userLoggedIn; ?>">
                <input type="hidden" name="user_to" value="<?php echo $username; ?>">

            </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" name="post_button" id="submit_profile_post">Post</button>
      </div>
    </div>
  </div>
</div>



    <script>
        var userLoggedIn='<?php echo $userLoggedIn; ?>';
        var profileUsername='<?php echo $username; ?>'
        $(document).ready(function(){
            $('#loading').show();
            //original ajax request for loading first posts
            $.ajax({
                url:"includes/handlers/ajax_load_profile_posts.php",
                type:"POST",
                data:"page=1&userLoggedIn=" + userLoggedIn +"&profileUsername=" +profileUsername,  //acces the request
                cache:false,

                success:function(data){
                    $('#loading').hide();
                    $('.posts_area').html(data);
                }
            });
            $(window).scroll(function(){    //when page not equal 1
                var height= $('.posts_area').height();  //div containing posts
                var scroll_top=$(this).scrollTop();
                var page=$('.posts_area').find('.nextPage').val();
                var noMorePosts = $('.posts_area').find('.noMorePosts').val();

                if((document.body.scrollHeight == document.body.scrollTop + window.innerHeight)&& noMorePosts=='false'){
                    $('#loading').show();   //law wsl l akher sfha w lsa fe posts 


                        var ajaxReq= $.ajax({
                            url:"includes/handlers/ajax_load_profile_posts.php",
                            type:"POST",
                            data:"page=" + page + "&userLoggedIn=" + userLoggedIn +"&profileUsername=" +profileUsername,
                            cache:false,

                            success:function(response){
                                $('.posts_area').find('.nextPage').remove(); //removes current .nextPage
                                $('.posts_area').find('.noMorePosts').remove(); //removes current .nextPage

                                $('#loading').hide();
                                $('.posts_area').append(response);
                            }
                        });
                } //end if
                return false;
            });// end  window . scroll function
        });

    </script>

   </div> <!--  //close of class wrapper that is in  header -->
</body>
</html>