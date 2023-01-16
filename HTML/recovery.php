<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\CSS\page-forms.css">
    <title>Recupero Password</title>
    <link rel="icon" type="image/x-icon" href="..\img\reset-password.png">
    <style>
        body {
            display: grid;
            place-items: center;
        }

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
    <form id="recovery">
        <fieldset>
            <legend>
                <img style="display: inline;" src="..\img\reset-password.png" alt="recovery" width="42px" height="42px">
                <h1 style="display: inline;">Recupero Password</h1>
            </legend>
            <p>Inserire il nome utente e l'indirizzo mail associato a esso</p>
            <input placeholder="Username" type="text" name="user" id="usr">
            <input placeholder="E-Mail" type="email" name="mail" id="mail">
            <input type="submit" value="Conferma">
            <p class="err" id="userError" hidden>Username non trovato!</p>
            <p class="err" id="mailError" hidden>Indirizzo email non trovato!</p>
            <p class="err" id="noData" hidden>I dati richiesti sono obbligatori!</p>
            <p class="err" id="noPaired" hidden>L'indirizzo mail non corrisponde a nessun Nome Utente!</p>
        </fieldset>
        <input type="button" onclick="location.href='index.php'" value="Indietro">
    </form>
    <script>
        const form = document.getElementById("recovery");

        form.onsubmit = recovery;

        function recovery(event){
            event.preventDefault();

            let data = new FormData(form);
                let x = new XMLHttpRequest();
                x.open("POST", "../PHP/getRecovery.php");
                x.onload = () => {
                    console.log(x.response);
                    const response = JSON.parse(x.response);
                    if (response["suitable"] === true) {
                        window.location.href = "../PHP/setNewPassword.php";
                    } else {
                        console.log(response);
                        let errMsg = "";
                        switch (response["error"]) {
                            case 1 /*Username non trovato*/ :
                                errMsg = document.getElementById("userError");
                                errMsg.hidden = false;
                                break;
                            
                            case 2 /*Mail non trovata*/:
                                errMsg = document.getElementById("mailError");
                                errMsg.hidden = false;
                                break;

                            case 3 /*Dati richiesti*/:
                                errMsg = document.getElementById("noData");
                                errMsg.hidden = false;
                                break;
                            
                            case 4 /*Mail e Username non collegati*/:
                                errMsg = document.getElementById("noPaired");
                                errMsg.hidden = false;
                                break;
                            
                            default:
                                console.log("Qualcosa si è inceppato...");
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