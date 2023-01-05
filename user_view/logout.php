<?php

session_start();
session_unset();
session_destroy();

//redirect
header("Location: ../index.php");

echo"<script type='text/javascript'>window.open('../index.php','_self')</script>"
?>