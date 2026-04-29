<?php
require_once("includes/header.php");
require_once("includes/classes/User.php");
require_once("includes/classes/Post.php");


if(isset($_POST['post'])){
    $post=new Post($con,$userLoggedIn);
    $post->submitPost($_POST['post_text'],"none");
    header("Location:index.php"); //refresh automatic
}
?>
        <div class="user_details column">
            <a href="<?php echo $userLoggedIn ?>"> <img src="<?php echo $user['profile_pic']?>" >  </a>
                <div class="user_details_left_right">
                        <a href="<?php echo $userLoggedIn ?>">
                        <?php 
                        echo $user['first_name']. " " .$user['last_name'];
                        
                        ?>
                        </a>
                        <br>

                        <?php 
                        echo "Posts: " . $user['num_posts']."<br>";
                        echo "Likes: ".$user['num_likes']."<br>";
                        ?>
                </div>
    </div>


    <div  class="main_column column">
        <form class="post_form" action="index.php" method="POST">
            <textarea name="post_text" id="post_text" placeholder="Got something to say?"></textarea>
            <input type="submit" name="post" id="post_button" value="Post">
            <hr>

        </form>

        <div class="posts_area"></div>
        <img id="loading" src="assets/images/icons/loading.gif">

    </div>
    <script>
        var userLoggedIn='<?php echo $userLoggedIn; ?>'
        $(document).ready(function(){
            $('#loading').show();
            //original ajax request for loading first posts
            $.ajax({
                url:"includes/handlers/ajax_load_posts.php",
                type:"POST",
                data:"page=1&userLoggedIn=" + userLoggedIn,  //acces the request
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
                            url:"includes/handlers/ajax_load_posts.php",
                            type:"POST",
                            data:"page=" + page + "&userLoggedIn=" + userLoggedIn,
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