<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/page-forms.css">
    <script src="../JS/utility.js"></script>
    <title>Index</title>
    <link rel="icon" type="image/x-icon" href="..\img\stopwatch.png">
    <style>
        h1{
            font-style: italic;
            font-family: 'Trebuchet MS';
            font-size: 50px;
            text-decoration: underline #0066ff;
            color: #803300;
        }

        body {
            display: grid;
            place-items: center;
        }

        #main{
            margin-bottom: 30%;
        }
    </style>
</head>
    <body>
        <div id="main">
            <div>
                <img src="..\img\stopwatch.png" alt="stopwatch_icon" width="64" height="64" style="display: inline;">
                <h1 style="display: inline;">Chronolet</h1>
            </div>
            <form id="login">
                <fieldset>
                    <legend><h2>Accedi</h2></legend>
                    <input placeholder="Username" type="text" name="user" id="usr">
                    <input placeholder="Password" type="password" name="pswd" id="psw">
                    <!-- <label>
                        Ricordami 
                        <input type="checkbox" name="keep" id="keep">
                    </label> -->
                    <input type="submit" value="Login">
                    <p class="err" id="loginError" hidden>Credenziali Errate</p>
                    <p class="err" id="noData" hidden>Vanno riempiti tutti i campi!</p>
                    <input type="button" onclick="location.href='../PHP/guestLog.php'" value="Entra come Guest">
                </fieldset>
                <input type="button" onclick="location.href='../HTML/register.php'" value="Registrati">
                <input type="button" onclick="location.href='../HTML/recovery.php'" value="Recupero Password">
            </form>
        </div>
        <script>
            const form = document.getElementById("login");
            
            form.onsubmit = login;

            function login(event){
                event.preventDefault();

                let data = new FormData(form);
                let x = new XMLHttpRequest();
                x.open("POST", "../PHP/login.php");
                
                x.onload = () => {
                    const response = JSON.parse(x.response);
                    document.getElementById("noData").hidden = true
                    document.getElementById("loginError").hidden = true;

                    if (response["logged"] === true) {
                        window.location.href = "../PHP/menu.php";
                    } else {
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
        </script>
    </body>
</html>