<?php
ob_start(); //turn on output buffering
session_start();

$timezone = date_default_timezone_set("Africa/Cairo");



$con=mysqli_connect("localhost","root","","social");

if(mysqli_connect_errno()){
    echo "Failed to connect:" . mysqli_connect_errno();
}



?>