<?php

//create connection to DB
$con=mysqli_connect('localhost','root','','antiquarian_bookshop');

//check connection - if not connected - raise an error
if(!$con){
    echo "Connection failed: " . mysqli_connect_error();
    exit();
}

?>