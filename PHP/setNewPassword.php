<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/page-forms.css">
    <link rel="icon" type="image/x-icon" href="../img/reset-password.png">
    <title>Reimposta Password</title>
    <style>
        #main{
            width: 40%;
            height: 40%;
        }

        p{
            color: #803300;
            font-family: Trebuchet MS;
            font-style: italic;
        }
    </style>
</head>
    <body>
        <?php
        require __DIR__ . '\files\utility.php';

        try{
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $pdo = connect();

            // recupero la domanda da fare all'utente
            $user = $_SESSION["user"];
            $query = "SELECT domanda
                        FROM utente
                        WHERE username = \"$user\"";
            $record = $pdo->query($query);
            $r = $record->fetch();

            // display interfaccia
            echo "<fieldset>";
            echo "<legend><h2>Scegli una nuova password!</h2></legend>";
            echo "<form id='reset'>";
            echo "<p><strong>".$r["domanda"]."</strong></p>";
            echo "<input placeholder='Risposta' type='text' name='answer'>";
            // le password hanno un formato controllato tramite regex all'interno dell'attributo pattern
            // come gia' fatto in index.php
            echo "<input placeholder='Nuova password' type='password' name='psw'
                pattern='(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}'
                title='Deve contenere almeno una lettera maiuscola, una minuscola, un numero e almeno 8 caratteri.'>";
            echo "<input placeholder='Ripeti password' type='password' name='re_psw'
                pattern='(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}'
                title='Deve contenere almeno una lettera maiuscola, una minuscola, un numero e almeno 8 caratteri.'>";
        } catch(Exception $e){
            echo "<h2>Qualcosa &egrave; andato storto!</h2>";
            echo "<input type='button' onclick='location.href=\"../HTML/index.php\"' value='Indietro'>";
        } finally {
            echo "<input type='submit' value='Imposta nuova Password'>";
            echo "</form>";
            $pdo = null;
        }
        ?>
        <div id="resetOk" hidden>
            <p class="success">Password reimpostata!</p>
            <input type="button" onclick="location.href='../HTML/index.php'" value="Vai alla Login">
        </div>
        <p class="err" id="badAnswer" hidden>La tua risposta non &egrave; corretta!Riprova</p>
        <p class="err" id="badPsw" hidden>Le due password non coincidono!</p>
        </fieldset>
        <script>
            const form = document.getElementById("reset");

            form.onsubmit = reset;

            function reset(event){
                event.preventDefault();

                let data = new FormData(form);
                    let x = new XMLHttpRequest();
                    x.open("POST", "requests/passwordValidate.php");
                    x.onload = () => {
                        console.log(x.response);
                        const response = JSON.parse(x.response);
                        if (response["ok"] === true) {
                            const form = document.getElementById("reset");
                            const succDiv = document.getElementById("resetOk");
                            const errors = document.getElementsByClassName("err");
                            console.log(errors);
                            // nascondo la form
                            form.hidden = true;
                            // messaggio di successo
                            succDiv.hidden = false;
                            // nascondo i messaggi di errore
                            for(let e of errors)
                                e.hidden = true;
                        } else {
                            // errori
                            console.log(response);
                            let errMsg = "";
                            switch(response["err"]){
                                case 1:
                                    errMsg = document.getElementById("badAnswer");
                                    errMsg.hidden = false;
                                    break;
                                case 2:
                                    errMsg = document.getElementById("badPsw");
                                    errMsg.hidden = false;
                                    break;
                                default:
                                    break;
                            }
                        }
                    };

                    x.onerror = (event) => console.log(event);
                    x.send(data);
            }
        </script>
    </body>
</html>