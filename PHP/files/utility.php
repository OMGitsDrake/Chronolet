<?php
    $messages = array(
        "emptyDB" => "<h2>Database da aggiornare</h2>",
        "loggedOnly" => "<div>Le funzioni disabilitate sono disponibili solo agli utenti registrati.</div>",
        "userNotFound" => "<h2>Utente non trovato!</h2><br>",
        "loginOk" => "<h2>Login avvenuto con successo!</h2>",
        "badLogin" => "<h2>Credenziali errate!</h2>",
        "notLogged" => "<h2>&Egrave; necessario autenticarsi</h2>"
    );

    function connect(){
        $connection = "mysql:host=localhost;dbname=chronolet";
        $user = "root";
        $pass = "Cic@da3310";
    
        $pdo = new PDO($connection, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        return $pdo;
    }

    function parse_millis($millis){
        $min = 0;
        $sec = 0;

        $sec = floor($millis / 1000);
        $dec = ceil(($millis / 1000 - $sec)*1000);
        
        if($sec >= 60){
            $min = floor($sec / 60);
            $sec %= 60;
        }

        return $min . ':' . $sec . '.' . $dec;
    }

    function isGuest(){
        return isset($_SESSION["user"]);
    }

    function random_str(
        int $length = 32,
        string $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ){
        $pieces = [];
        $max = mb_strlen($chars, '8bit') - 1;
        for ($i = 0; $i < $length; $i++)
            $pieces []= $chars[random_int(0, $max)];
        
        return implode($pieces);
    }
?>