<?php

session_start();
session_unset();
session_destroy();

//redirect
header("Location: ./admin_login.php");

echo"<script type='text/javascript'>window.open('./admin_login.php','_self')</script>"
?>