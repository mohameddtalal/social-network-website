<?php
require_once(__DIR__ . "/../../config/config.php");
require_once(__DIR__ . "/../classes/User.php");
require_once(__DIR__ . "/../classes/Message.php");


$query=$_POST['query'];
$userLoggedIn=$_POST['userLoggedIn'];

$names= explode(" ",$query);

// if query contains _ , assume user is earching for user name 

if(strpos($query,'_') !== false){
    $usersReturnedQuery=mysqli_query($con,"SELECT * FROM users WHERE username LIKE '$query%' AND user_closed='no' LIMIT 8");   
}

//if there is two words, assume first and last name respectively

else if(count($names)==2){
    $usersReturnedQuery=mysqli_query($con,"SELECT * FROM users WHERE (first_name LIKE '$names[0]%' AND last_name LIKE '$names[1]%') AND user_closed='no' LIMIT 8");   
}
//if query has one word search first name or last name
else{
     $usersReturnedQuery=mysqli_query($con,"SELECT * FROM users WHERE (first_name LIKE '$names[0]%' OR last_name LIKE '$names[0]%') AND user_closed='no' LIMIT 8");   

}
if($query != ""){
    while($row = mysqli_fetch_array($usersReturnedQuery)){
        $user= new User($con,$userLoggedIn);
        if($row['username'] != $userLoggedIn)
            $mutual_friends= $user->getMutualFriends($row['username']) . " friend in common";
        else
            $mutual_friends="";
        echo "<div class='resultDisplay'>
            <a href='". $row['username']."' style='color:#1485bd'>
                <div class='liveSearchProfilePic'>
                    <img src='". $row['profile_pic']."'>
                </div>
                <div class='liveSearchText'>
                   " . $row['first_name'] . " ".$row['last_name']."
                   <p>" .$row['username'] . "</p>
                   <p id='grey'>" .$mutual_friends."</p>
                </div>
            </a>

        </div>";
    }
}





?>