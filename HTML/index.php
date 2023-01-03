<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../CSS/index.css"> -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> -->
    <script src="../JS/utility.js"></script>
    <style>
        body{
            min-height: 100vh; /**Relative to 1% of the height of the viewport */
            display: flex;
            flex-direction: column;
        }
        footer{
            margin-top: auto;
        }
    </style>
    <title>Index</title>
</head>
    <body>
        <div>
            <h1>Chronolet</h1>
            <form id="login">
                <fieldset>
                    <legend><h2>Accedi</h2></legend>
                    <?php
                        if (isset($_COOKIE["username"]))
                            echo "<input placeholder='Username' type='text' name='user' id='usr' value='".$_COOKIE["username"]."'><br>";
                        else 
                            echo "<input placeholder='Username' type='text' name='user' id='usr'><br>";
                    ?>
                    <input placeholder="Password" type="password" name="pswd" id="psw"><br>
                    <label class="container">
                        Ricordami 
                        <input type="checkbox" name="keep" id="keep">
                    </label><br>
                    <input type="submit" value="Login"><br>
                    <p class="err" id="loginError" hidden>Credenziali Errate</p>
                    <p class="err" id="noData" hidden>Dati richiesti!</p>
                </fieldset>
            </form>
            <input type="button" onclick="location.href='../HTML/register.php'" value="Registrati">
            <input type="button" onclick="location.href='../HTML/recovery.php'" value="Recupero Password">
            <input type="button" onclick="location.href='../PHP/guestLog.php'" value="Entra come Guest">
        </div>
        
        <footer>
            <h2>footer title</h2>
            <span>
                some footer text 1
            </span>
            <span>
                some footer text 2
            </span>
        </footer>

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