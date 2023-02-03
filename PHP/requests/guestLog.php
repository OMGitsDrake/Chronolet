<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // mi salvo che sono un ospite
    $_SESSION["logged"] = false;

    header("Location:../menu.php");
?>