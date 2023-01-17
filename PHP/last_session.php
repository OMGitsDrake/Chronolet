<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/stopwatch.png">
    <title>Ultima Sessione</title>
</head>
    <body>
        <fieldset>
            <legend>
                <img src="../img/circuit.png" alt="icon" width="32" height="32" style="display: inline">
                <h2 style="display: inline">Seleziona un circuito</h2>
            </legend>
            <?php
            require __DIR__ . '\files\utility.php';

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            try{
                $pdo = connect();

                $sql = "SELECT nome FROM circuito";
                $set = $pdo->query($sql);
                if($set->rowCount() < 1)
                    throw new Exception(0);
                
                echo "<form id='circuitData'>";
                echo "<select name='selezione_circuiti' id='circuito'>";        
                echo "<option>Scegli...</option>";
                while($record = $set->fetch()){
                    echo "<option>".$record["nome"]."</option>";
                }
                echo "</select>";
                
                echo "<input type='submit' value='Seleziona'>";
                echo "</form>";
            } catch(Exception $e){
                echo $messages["emptyDB"];
            } finally {
                $pdo = null;
            }
        ?>
        <p class="err" id="noData" hidden>Devi prima selezionare un circuito!</p>
        <p class="warn" id="emptyDB" hidden>Non hai ancora fatto nessun giro!</p>
        <input type="button" onclick="location.href='menu.php'" value="Indietro">
        </fieldset>
        <fieldset id="fieldset" hidden>
            <legend>
                <img src="..\img\stopwatch.png" alt="icon" width="32" height="32" style="display: inline">
                <h2 style="display: inline">Ultima Sessione Registrata</h2>
            </legend>
        </fieldset>
        <link rel="stylesheet" href="..\CSS\menu.css">
        <style>
            td.best{
                background-color: rgba(0, 255, 110, 0.5);
            }
        </style>
        <script>
            const form = document.getElementById("circuitData");

            form.onsubmit = reqData;

            function reqData(event){
                event.preventDefault();

                let data = new FormData(form);
                let x = new XMLHttpRequest();
                x.open("POST", "requests/getLastSession.php");

                x.onload = () => {
                    const response = JSON.parse(x.response);
                    if(response['ok'] === true){
                        console.log(response);
                        document.getElementById("noData").hidden = true;
                        document.getElementById("emptyDB").hidden = true;
                        document.getElementById("fieldset").hidden = false;
                        if(document.getElementById("lastSessionTable") != undefined){
                            let t = document.getElementById("lastSessionTable");
                            t.parentNode.removeChild(t);
                        }
                        const table = document.createElement("table");
                        table.setAttribute("id", "lastSessionTable");
                        document.getElementById("fieldset").appendChild(table);
                        const caption = document.createElement("tr");
                        caption.appendChild(document.createElement("td"));
                        caption.lastChild.setAttribute("class", "caption");
                        caption.lastChild.setAttribute("colspan", "6");
                        table.appendChild(caption);
                        caption.lastChild.appendChild(document.createTextNode(response['circuit'] + " - " + response['date']));

                        tempi = response['times'];
                        let best = Infinity;

                        // assegnazione miglior tempo
                        for (let i = 0; i < tempi.length; i++)
                            best = (tempi[i][1] < best) ? tempi[i][1] : best;

                        heads = new Array(
                            "Moto",
                            "Tempo",
                            "T1",
                            "T2",
                            "T3",
                            "T4"
                        );
                        table.appendChild(document.createElement("tr"));
                        for(let i = 0; i < heads.length; i++){
                            table.lastChild.appendChild(document.createElement("th"));
                            table.lastChild.lastChild.appendChild(document.createTextNode(heads[i]));
                        }

                        for (let i = 0; i < tempi.length; i++) {
                            table.appendChild(document.createElement("tr"));
                            for (let j = 0; j < tempi[i].length; j++) {
                                table.lastChild.appendChild(document.createElement("td"));
                                if(j == 0)
                                    table.lastChild.lastChild.appendChild(document.createTextNode(tempi[i][j]));
                                else {
                                    table.lastChild.lastChild.appendChild(document.createTextNode(parseMillis(tempi[i][j])));
                                    if(tempi[i][1] == best)
                                        table.lastChild.firstChild.setAttribute("class", "best");
                                }
                            }
                        }
                    } else {
                        console.log(response);
                        document.getElementById("noData").hidden = true;
                        document.getElementById("emptyDB").hidden = true;
                        let errMsg = "";

                        switch(response['err']){
                            case 0:
                                errMsg = document.getElementById("noData");
                                errMsg.hidden = false;
                                break;
                            case 1:
                                errMsg = document.getElementById("emptyDB");
                                errMsg.hidden = false;
                                break;
                            default:
                                break;
                        }
                    }
                }

                x.onerror = (event) => console.log(event);
                x.send(data);
            }

            function parseMillis(millis){
                min = 0;
                sec = 0;

                sec = Math.floor(millis / 1000);
                dec = Math.ceil((millis / 1000 - sec)*1000);
                
                if(sec >= 60){
                    min = Math.floor(sec / 60);
                    sec %= 60;
                }
                sec = (sec < 10) ? "0"+sec : sec;

                return min + ':' + sec + '.' + dec;
            }
        </script>
    </body>
</html>