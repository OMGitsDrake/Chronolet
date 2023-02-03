<?php
    // script per eliminare ogni traccia dell'utente nella sessione
    session_start();
    session_regenerate_id();
    session_destroy();
    
    header("Location: ../../HTML/index.php");
?>