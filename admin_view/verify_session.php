<?php

if( (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) ){
    header('HTTP/1.0 403 Forbidden, true, 403');
    http_response_code(403);
    print('Error ' . http_response_code());
    exit();
}

?>