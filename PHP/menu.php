<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
</head>
    <body>
        <?php
            require __DIR__ . '\files\utility.php';
            
            session_start();
            if(!$_SESSION["logged"]){
                $_SESSION["user"] = "";
                echo "<h1>Benvenuto!</h1>";
                echo $messages["loggedOnly"];
            } else {
                echo "<h1>Benvenuto ".$_SESSION["user"]."!</h1>";
            }
            if(isset($_COOKIE["username"]))
                echo "cookie set: ".$_COOKIE["username"];
            else
                echo "cookie not set";
        ?>

        <!-- TODO Riassunto visivo -->
        <div class="container">
            <h3>Menu</h3>
            <?php
                if(!$_SESSION["logged"]){
                    echo "<input disabled type='button' onclick='location.href=\"storico.php\"' value='Storico Tempi'>";
                    echo "<input disabled type='button' onclick='location.href=\"last_session.php\"' value='Ultima Sessione'>";
                    echo "<input type='button' onclick='location.href=\"classifiche.php\"' value='Classifiche'>";
                    echo "<input type='button' onclick='location.href=\"nuova_sessione.php\"' value='Inizia Nuova Sessione'>";
                    echo "<input type='button' onclick='location.href=\"elenco.php\"' value='Elenco Circuiti'>";
                    echo "<input type='button' onclick='location.href=\"quit.php\"' value='Esci'>";
                } else {
                    echo "<input type='button' onclick='location.href=\"storico.php\"' value='Storico Tempi'>";
                    echo "<input type='button' onclick='location.href=\"last_session.php\"' value='Ultima Sessione'>";
                    echo "<input type='button' onclick='location.href=\"classifiche.php\"' value='Classifiche'>";
                    echo "<input type='button' onclick='location.href=\"nuova_sessione.php\"' value='Inizia Nuova Sessione'>";
                    echo "<input type='button' onclick='location.href=\"elenco.php\"' value='Elenco Circuiti'>";
                    echo "<input type='button' onclick='location.href=\"../HTML/index.php\"' value='Esci'>";
                }
            ?>
        </div>
    </body>
</html>