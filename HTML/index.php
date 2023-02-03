<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/page-forms.css">
    <title>Index</title>
    <link rel="icon" type="image/x-icon" href="../img/stopwatch.png">
    <style>
        h1{
            font-style: italic;
            font-family: 'Trebuchet MS';
            font-size: 50px;
            text-decoration: underline #0066ff;
            color: #803300;
        }

        #main{
            margin-bottom: 30%;
        }
    </style>
</head>
    <body>
        <div id="main">
            <!-- Titolo -->
            <div>
                <img src="../img/stopwatch.png" alt="stopwatch_icon" width="64" height="64" style="display: inline;">
                <h1 style="display: inline;">Chronolet</h1>
            </div>
            <!-- Form per login -->
            <form id="login">
                <fieldset>
                    <legend><h2>Accedi</h2></legend>
                    <input placeholder="Username" type="text" name="user" id="usr">
                    <input placeholder="Password" type="password" name="pswd" id="psw">
                    <input type="button" value="Mostra Password" id="showPswBtn" onclick="togglePswText()" style="font-size: 15px;">
                    <input type="submit" value="Accedi">
                    <p class="err" id="loginError" hidden>Credenziali Errate</p>
                    <p class="err" id="noData" hidden>Vanno riempiti tutti i campi!</p>
                    <input type="button" onclick="location.href='../PHP/requests/guestLog.php'" value="Entra come Ospite">
                </fieldset>
                <input type="button" onclick="location.href='../HTML/register.php'" value="Registrati">
                <input type="button" onclick="location.href='../HTML/recovery.php'" value="Recupero Password">
                <input type="button" onclick="location.href='../HTML/manuale.html'" value="Manuale d'uso">
            </form>
        </div>
        <script>
            const form = document.getElementById("login");
            
            form.onsubmit = login;

            function login(event){
                event.preventDefault();

                let data = new FormData(form);
                let x = new XMLHttpRequest();
                x.open("POST", "../PHP/requests/login.php");
                
                x.onload = () => {
                    const response = JSON.parse(x.response);
                    // nascondo i messaggi di errore quando ricevo una risposta
                    document.getElementById("noData").hidden = true
                    document.getElementById("loginError").hidden = true;

                    if (response["logged"] === true) {
                        // reindirizzamento
                        window.location.href = "../PHP/menu.php";
                    } else {
                        // mostro errori a schermo
                        console.log(response);
                        if(response["error"] == 0/*"Dati richiesti!"*/){
                            const errMsg = document.getElementById("noData");
                            errMsg.hidden = false;
                        } else {
                            const errMsg = document.getElementById("loginError");
                            errMsg.hidden = false;
                        }
                    }
                };

                x.onerror = (event) => console.log(event);
                x.send(data);
            }

            /**
             * Funzione che mostra il testo della password che si sta inserendo
             */
            function togglePswText() {
                const p = document.getElementById("psw");
                const b = document.getElementById("showPswBtn");
                if (p.type === "password"){
                    p.type = "text";
                    b.value = "Nascondi Password";
                }
                else{
                    p.type = "password";
                    b.value = "Mostra Password";
                }
            }
        </script>
    </body>
</html>