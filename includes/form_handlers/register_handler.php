<?php

//declaring variables to prevent error
$fname=""; //First name
$lname="";//Last name
$em="";//email
$em2=""; //email 2
$password="";
$password2="";
$date=""; //date sign up
$error_array=array(); // holds error messages

if(isset($_POST['register_button'])){
    //registration form values
    //Fisr name
    $fname=strip_tags($_POST['reg_fname']);  //take away any html tags
    $fname=str_replace(' ','',$fname);
    $fname=ucfirst(strtolower($fname));
    $_SESSION['reg_fname']=$fname; //store first name into session variable

    //Last name
    $lname=strip_tags($_POST['reg_lname']);
    $lname=str_replace(' ','',$lname);
    $lname=ucfirst(strtolower($lname));
    $_SESSION['reg_lname']=$lname;


    //email
    $em=strip_tags($_POST['reg_email']);
    $em=str_replace(' ','',$em);
    $em=ucfirst(strtolower($em));
     $_SESSION['reg_email']=$em;


    //email 2
    $em2=strip_tags($_POST['reg_email2']);
    $em2=str_replace(' ','',$em2);
    $em2=ucfirst(strtolower($em2));
    $_SESSION['reg_email2']=$em2;

    //password
    $password=strip_tags($_POST['reg_password']);


    //password 2
    $password2=strip_tags($_POST['reg_password2']);

    //date
    $date=date("Y-m-d"); //keep current day

    if($em==$em2){
        //check if email is invalid format
        if(filter_var($em,FILTER_VALIDATE_EMAIL)){
            $em=filter_var($em,FILTER_VALIDATE_EMAIL);
            //check if email already exists
            $e_check=mysqli_query($con,"SELECT email FROM users WHERE email='$em'");
            //count number of rows returned
            $num_rows=mysqli_num_rows($e_check);
            if($num_rows>0){
                array_push($error_array,"Email already in use<br>") ;
            }
        }
        else{
           array_push($error_array,"Invalid email format<br>") ;
        }
    }
    else{
        array_push($error_array,"Emails don't match<br>")  ;
    }

    if(strlen($fname) > 25 || strlen($fname) < 2){
       array_push($error_array,"Your first name must be between 2 and 25 characters<br>");
    }
    if(strlen($lname) > 25 || strlen($lname) < 2){
        array_push($error_array,"Your last name must be between 2 and 25 characters<br>");
    }
    if($password != $password2){
       array_push($error_array,"Your password do not match<br>");
    }
    else{
        if(preg_match('/[^A-Za-z0-9]/',$password)) {
          array_push($error_array,"Your password can contain only english characters or numbers<br>");
        }

    }
    if(strlen($password) > 30 || strlen($password) < 5) {
        array_push($error_array, "your password must be between 5 and 30 characters<br>");
    }

    if(empty($error_array)){
        $password = md5($password); //encrypt password before sending to database

        //Generate username by concatenating first name and last name

        $username= strtolower($fname . "_" .$lname);
        $check_username_query=mysqli_query($con,"SELECT username FROM users WHERE username='$username' ");

        $i =0;
        //if user name exist add number to username

        while (mysqli_num_rows($check_username_query) !=0){
            $i++; //add one to i if there is an user
            $username=$username ."_" .$i;
            $check_username_query=mysqli_query($con,"SELECT username FROM users WHERE username='$username'");

        }

        // profile picture assignment
        $rand = rand(1,2); //rnadom number between 1 and 2
        if($rand==1){
             $profile_pic = "assets/images/profile_pics/defaults/head_deep_blue.png";
        }
          if($rand==2){
             $profile_pic = "assets/images/profile_pics/defaults/head_emerald.png";
        }

        $query=mysqli_query($con ,"INSERT INTO users VALUES ('','$fname','$lname','$username','$em','$password','$date' , '$profile_pic' ,'0','0','no',',' )");

        array_push($error_array,"<span style='color:#14C800;'> you're all set! Goahead and login!</span><br>");

        //clear session variables after sign up

        $_SESSION['reg_fname']="";
        $_SESSION['reg_lname']="";
        $_SESSION['reg_email']="";
        $_SESSION['reg_email2']="";
    }
}



?>