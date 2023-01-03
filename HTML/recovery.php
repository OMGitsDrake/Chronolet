<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recupero Password</title>
</head>
<body>
    <fieldset>
        <legend><h2>Recupero Password</h2></legend>
        <p>Inserire il nome utente e l'indirizzo mail associato a esso</p>
        <form id="recovery">
            <input placeholder="Username" type="text" name="user" id="usr"><br>
            <input placeholder="E-Mail" type="email" name="mail" id="mail"><br>
            <input type="submit" value="Conferma"><br>
            <p class="err" id="userError" hidden>Username non trovato!</p>
            <p class="err" id="mailError" hidden>Indirizzo email non trovato!</p>
            <p class="err" id="noData" hidden>I dati richiesti sono obbligatori!</p>
            <p class="err" id="noPaired" hidden>L'indirizzo mail non corrisponde a nessun Nome Utente!</p>
        </form>
        <input type="button" onclick="location.href='index.php'" value="Indietro">
    </fieldset>
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