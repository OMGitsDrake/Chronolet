<?php
    session_start();
    unset($_SESSION);
    header("Location: ../HTML/index.php");
?>