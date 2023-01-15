<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header('HTTP/1.0 401 Unauthorized, true, 401');
    http_response_code(401);
    print('Error ' . http_response_code());
    exit();
}else{
    //redirect
    header("Location: ./user_settings.php");

    echo"<script type='text/javascript'>window.open('./user_settings.php','_self')</script>";
}
?>