<?php
    session_start();
    session_regenerate_id();
    session_destroy();
    
    header("Location: ../../HTML/index.php");
?>