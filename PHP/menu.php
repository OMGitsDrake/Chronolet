<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <script src="../JS/utility.js"></script>
</head>
    <body id="main">
        <?php
            require __DIR__ . '\files\utility.php';
            
            if(session_status() === PHP_SESSION_NONE)
                session_start();
            
            if(!$_SESSION["logged"]){
                $_SESSION["user"] = "";
                echo "<h1>Benvenuto!</h1>";
                echo $messages["loggedOnly"];
            } else
                echo "<h1>Benvenuto ".$_SESSION["user"]."!</h1>";
        ?>

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
                    echo "<input type='button' onclick='location.href=\"quit.php\"' value='Esci'>";
                }
                ?>
        </div>
        
        <!-- Riassunto visivo -->
        <div class="floater" id="recap">
            <fieldset>
                <legend><h2>Riassunto</h2></legend>
                <table id="recapTable">
                    
                </table>    
                <p class="warn" id="noData" hidden>
                    Recap non ancora disponibile!<br>
                    Vai a fare qualche giro in pista.
                </p>
                <p class="err" id="clientErr" hidden>
                    Spiacenti, il sito &egrave; in manutenzione.
                </p>
                <p class="warn" id="noLogin" hidden>
                    La funzione di Riassunto è disponibile solo agli utenti Registrati. <br>
                    Registrati <a href="../HTML/register.php">qui</a>
                </p>
            </fieldset>
        </div>
        <script>
            const body = document.getElementById("main");

            body.onload = getRecap;

            function getRecap(event){
                event.preventDefault();
                
                let x = new XMLHttpRequest();
                x.open("GET", "getRecap.php");
                x.onload = () => {
                    const response = JSON.parse(x.response);
                    if(response['ok'] === true){
                        console.log(response['msg']);
                        const recap = response['msg'];
                        
                        const table = document.getElementById("recapTable");

                        const heads = new Array(
                            "Circuito",
                            "Tempo"
                        )
                        table.appendChild(document.createElement("tr"));
                        heads.forEach(e => {
                            table.lastChild.appendChild(document.createElement("th"));
                            table.lastChild.lastChild.appendChild(document.createTextNode(e));
                        });

                        for(let i = 0; i < recap["circuito"].length; i++){
                            table.appendChild(document.createElement("tr"));
                            table.lastChild.appendChild(document.createElement("td"));
                            table.lastChild.lastChild.appendChild(document.createTextNode(recap["circuito"][i]));
                            table.lastChild.appendChild(document.createElement("td"));
                            table.lastChild.lastChild.appendChild(document.createTextNode(recap["best"][i]));
                        }
                        
                    } else {
                        console.log(response);
                        let errMsg = "";
                        switch(response["error"]){
                            case 0:
                                errMsg = document.getElementById("noData");
                                errMsg.hidden = false;
                                break;
                            case 1:
                                errMsg = document.getElementById("clientErr");
                                errMsg.hidden = false;
                                break;
                            case 2:
                                errMsg = document.getElementById("noLogin");
                                errMsg.hidden = false;
                                break;
                            default:
                                break;
                        }
                    }
                };

                x.onerror = (event) => console.log(event);
                x.send();
            }
        </script>
    </body>
</html>