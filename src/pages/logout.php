<?php
    //desconectar o usuário da nossa aplicação web
    session_start();
    $_SESSION = array();
    session_destroy();
    header("location: ../../index.php");
?>
