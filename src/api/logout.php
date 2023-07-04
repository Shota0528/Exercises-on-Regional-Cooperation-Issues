<?php
    session_start();
    $_SESSION = [];
    session_destroy();
    header('Location: http://localhost/logout.php');
    exit();
?>