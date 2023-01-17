<?php
    $messages = array(
        "emptyDB" => "<h2>Database da aggiornare</h2>",
        "loggedOnly" => "<p class='warn'>Le funzioni disabilitate sono disponibili solo agli utenti registrati.</p>",
        "userNotFound" => "<h2>Utente non trovato!</h2><br>",
        "loginOk" => "<h2>Login avvenuto con successo!</h2>",
        "badLogin" => "<h2>Credenziali errate!</h2>",
        "notLogged" => "<h2>&Egrave; necessario autenticarsi</h2>"
    );

    function isLogged(){
        try{
            if (!isset($_SESSION['logged']))
                throw new Exception();

        } catch(Exception $e){
            header("Location: ../HTML/pageNotFound.html");
        }
    }

    function connect(){
        $connection = "mysql:host=localhost;dbname=chronolet";
        $user = "root";
        $pass = "Cic@da3310";
    
        $pdo = new PDO($connection, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        return $pdo;
    }

    function generate_time($c){
        $time = array();
        
        switch ($c) {
            case "Autodromo dell'Umbria":    
                $time[0] = 0;
                $time[1] = floor(floor(rand(68000, 105000)/4));
                $time[2] = floor(floor(rand(68000, 105000)/8));
                $time[3] = floor(floor(rand(68000, 105000)/4));
                $time[4] = floor(floor(rand(68000, 105000)*(3/8)));
                for ($i = 1; $i <= 4; $i++)
                    $time[0] += $time[$i];
                
                break;

            case "Autodromo Vallelunga":
                $time[0] = 0;
                $time[1] = floor(floor(rand(98000, 140000))/3);
                $time[2] = floor(floor(rand(98000, 140000))/4);
                $time[3] = floor(floor(rand(98000, 140000))/4);
                $time[4] = floor(floor(rand(98000, 140000))/6);
                for ($i = 1; $i <= 4; $i++)
                    $time[0] += $time[$i];
                break;
                    
            case "Cremona Circuit":
                $time[0] = 0;
                $time[1] = floor(floor(rand(95000, 130000))/5);
                $time[2] = floor(floor(rand(95000, 130000))/4);
                $time[3] = floor(floor(rand(95000, 130000))/4);
                $time[4] = floor(floor(rand(95000, 130000))*(3/10));
                for ($i = 1; $i <= 4; $i++)
                    $time[0] += $time[$i];
                break;

            case "Mugello Circuit":
                $time[0] = 0;
                $time[1] = floor(floor(rand(105000, 145000))/4);
                $time[2] = floor(floor(rand(105000, 145000))/3);
                $time[3] = floor(floor(rand(105000, 145000))/8);
                $time[4] = floor(floor(rand(105000, 145000))*(7/24));
                for ($i = 1; $i <= 4; $i++)
                    $time[0] += $time[$i];
                break;

            case "Misano World Circuit":
                $time[0] = 0;
                $time[1] = floor(floor(rand(92000, 120000))/4);
                $time[2] = floor(floor(rand(92000, 120000))*(2/5));
                $time[3] = floor(floor(rand(92000, 120000))*(1/5));
                $time[4] = floor(floor(rand(92000, 120000))*(3/20));
                for ($i = 1; $i <= 4; $i++)
                    $time[0] += $time[$i];
                break;

            case "Autodromo del Levante":
                $time[0] = 0;
                $time[1] = floor(floor(rand(52000, 76000))/4);
                $time[2] = floor(floor(rand(52000, 76000))*(2/5));
                $time[3] = floor(floor(rand(52000, 76000))*(1/5));
                $time[4] = floor(floor(rand(52000, 76000))*(3/20));
                for ($i = 1; $i <= 4; $i++)
                    $time[0] += $time[$i];
                break;

            case "Autodromo di Imola":
                $time[0] = 0;
                $time[1] = floor(floor(rand(92000, 136000))/4);
                $time[2] = floor(floor(rand(92000, 136000))*(2/5));
                $time[3] = floor(floor(rand(92000, 136000))*(1/5));
                $time[4] = floor(floor(rand(92000, 136000))*(3/20));
                for ($i = 1; $i <= 4; $i++)
                    $time[0] += $time[$i];
                break;

            case "Autodromo Nazionale Gianni de Luca":
                $time[0] = 0;
                $time[1] = floor(floor(rand(44000, 62000))/4);
                $time[2] = floor(floor(rand(44000, 62000))*(2/5));
                $time[3] = floor(floor(rand(44000, 62000))*(1/5));
                $time[4] = floor(floor(rand(44000, 62000))*(3/20));
                for ($i = 1; $i <= 4; $i++)
                    $time[0] += $time[$i];
                break;

            case "Circuito Tazio Nuvolari Cervesina":
                $time[0] = 0;
                $time[1] = floor(floor(rand(64000, 92000))/4);
                $time[2] = floor(floor(rand(64000, 92000))*(2/5));
                $time[3] = floor(floor(rand(64000, 92000))*(1/5));
                $time[4] = floor(floor(rand(64000, 92000))*(3/20));
                for ($i = 1; $i <= 4; $i++)
                    $time[0] += $time[$i];
                break;

            case "Motodromo Castelletto di Branduzzo":
                $time[0] = 0;
                $time[1] = floor(floor(rand(51000, 85000))/4);
                $time[2] = floor(floor(rand(51000, 85000))*(2/5));
                $time[3] = floor(floor(rand(51000, 85000))*(1/5));
                $time[4] = floor(floor(rand(51000, 85000))*(3/20));
                for ($i = 1; $i <= 4; $i++)
                    $time[0] += $time[$i];
                break;
            
            default:
                return -1;
        }
        return $time;
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