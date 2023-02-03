<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/page-forms.css">
    <title>Registrati</title>
    <link rel="icon" type="image/x-icon" href="../img/add-user.png">
    <style>
        body {
            display: grid;
            place-items: center;
        }

        #main{
            width: 40%;
            height: 40%;
            margin-bottom: 40%;
        }

        label{
            color: #803300;
            font-family: Trebuchet MS;
            font-style: italic;
            font-size: 20px;
        }
    </style>
</head>
    <body>
        <div id="main">
            <form id="sign">
                <fieldset>
                    <!-- Titolo -->
                    <legend>
                        <img style="display: inline;" src="../img/add-user.png" alt="signup" width="32" height="32">
                        <h1 style="display: inline;">Registrati</h1>
                    </legend>
                    <input placeholder="Username" type="text" name="user" id="usr" pattern="^[a-zA-Z0-9]{4,10}$"
                        title="Deve contenere solamente caratteri alfanumerici!">
                    <input placeholder="E-Mail" type="email" name="mail" id="mail">
                    <!-- La correttezza del formato delle password e' controllato atraverso una regex indicata nell'attributo pattern -->
                    <input placeholder="Password" type="password" name="pswd" id="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                        title="Deve contenere almeno una lettera maiuscola, una minuscola, un numero e almeno 8 caratteri.">
                    <input placeholder="Ripeti Password" type="password" name="re_pswd" id="re_psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                        title="Deve contenere almeno una lettera maiuscola, una minuscola, un numero e almeno 8 caratteri.">
                    <label for="question">
                        Domanda di sicurezza
                    </label> 
                    <select name="question" style="margin-top: 0;">
                        <option>Scegli...</option>
                        <option>Qual&apos; &egrave; il nome del tuo amico immaginario da bambino?</option>
                        <option>Come si chiama il tuo primo amore?</option>
                        <option>Qual&apos; &egrave; il primo esame che hai passato?</option>
                        <option>Qual&apos; &egrave; il tuo colore preferito?</option>
                        <option>Qual&apos; &egrave; stato il tuo primo giocattolo?</option>
                    </select> 
                    <input placeholder="Risposta" type="text" name="answer">
                    <input type="submit" value="Conferma">
                    <!-- Errori -->                
                    <p class="err" id="pswdError" hidden>Le password non coincidono!</p>
                    <p class="err" id="userError" hidden>Nome utente non disponibile!</p>
                    <p class="err" id="noData" hidden>Tutti i dati richiesti sono obbligatori!</p>
                </fieldset>
                </form>
                <input type="button" onclick="location.href='index.php'" value="Indietro">
        </div>
        <script>
            const form = document.getElementById("sign");
            
            form.onsubmit = sign;

            function sign(event){
                event.preventDefault();

                let data = new FormData(form);
                let x = new XMLHttpRequest();
                x.open("POST", "../PHP/requests/register.php");
                x.onload = () => {
                    const response = JSON.parse(x.response);
                    document.getElementById("pswdError").hidden = true;
                    document.getElementById("userError").hidden = true;
                    document.getElementById("noData").hidden = true;
                    if (response["sign"] === true) {
                        // reindirizzamento
                        window.location.href = "../HTML/index.php";
                    } else {
                        // errori
                        console.log(response);
                        let errMsg = "";
                        switch (response["error"]) {
                            case 0 /*"Le password non coincidono!"*/:
                                errMsg = document.getElementById("pswdError");
                                errMsg.hidden = false;
                                break;
                            
                            case 1 /*"Nome utente non disponibile!"*/:
                                errMsg = document.getElementById("userError");
                                errMsg.hidden = false;
                                break;

                            case 2 /*"Dati richiesti!"*/:
                                errMsg = document.getElementById("noData");
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