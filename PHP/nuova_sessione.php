<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\CSS\menu.css">
    <link rel="icon" type="image/x-icon" href="..\img\hot-deal.png">
    <title>Nuova Sessione</title>
    <style>
        td.best{
            background-color: rgba(0, 255, 110, 0.5);
        }
        
        tr.ideal{
            background-color: red;
            color: white;
        }

        table{
            margin-top: 10px;
        }
    </style>
</head>
    <body>
        <fieldset>
            <legend>
                <img src="..\img\hot-deal.png" alt="icon" width="64" height="64" style="display: inline;">
                <h1 style="display: inline;">Nuova Sessione Cronometrata</h1>
            </legend>
            <form id="sessionForm">  
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
                    throw new Exception();
                
                echo "<select name='selezione_circuito' id='circuito'>";        
                echo "<option>Seleziona Circuito</option>";
                while($record = $set->fetch()){
                    echo "<option>".$record["nome"]."</option>";
                }
                echo "</select>";
        
                $sql = "SELECT marca, modello FROM archiviomoto";
                $set = $pdo->query($sql);
                if($set->rowCount() < 1)
                    throw new Exception();
                
                echo "<select name='selezione_moto' id='moto'>";
                echo "<option>Seleziona Moto</option>";        
                while($record = $set->fetch()){
                    echo "<option>".$record["marca"]." ".$record["modello"]."</option>";
                }
                echo "<option>Altro...</option>";
                echo "</select>";
                
            } catch(Exception $e){
                echo $messages["emptyDB"];
                echo "<input type='button' onclick='location.href=\"menu.php\"' value='Indietro'>";
            } finally {
                $pdo = null;
            }
        ?>
        <input type="submit" value="Avvia">
        <input type="button" onclick="location.href='menu.php'" value="Indietro">
        </form>
        <div id="errDiv">
            <p class="err" id="noData" hidden>Entrambi i campi richiesti sono obbligatori!</p>
            <p class="err" id="serverErr" hidden>Spiacenti, il server &egrave; in manutenzione!</p>
        </div>
        </fieldset>
        <table id="res">
        </table>
        <script>
            const form = document.getElementById("sessionForm");
            form.onsubmit = reqSession;

            let currentTurn = 1;
            function reqSession(event){
                event.preventDefault();

                let data = new FormData(form);
                let x = new XMLHttpRequest();
                x.open("POST", "requests/getNewTimes.php");

                x.onload = () => {
                    const response = JSON.parse(x.response);
                    if(response['ok'] === true){
                        console.log(response);
                        document.getElementById("errDiv").hidden = true;
                        const tempi = response['tempi'];
                        const moto = response['moto'];
                        let best = Infinity;
                        let bestSectors = new Array(4);
                        bestSectors[0] = Infinity;
                        bestSectors[1] = Infinity;
                        bestSectors[2] = Infinity;
                        bestSectors[3] = Infinity;

                        // assegnazione miglior tempo
                        for (let i = 0; i < tempi.length; i++)
                            best = (tempi[i][0] < best) ? tempi[i][0] : best;

                        // assegnazione migliori settori
                        for (let i = 0; i < tempi.length; i++) {
                            bestSectors[0] = (tempi[i][1] < bestSectors[0]) ? tempi[i][1] : bestSectors[0];
                            bestSectors[1] = (tempi[i][2] < bestSectors[1]) ? tempi[i][2] : bestSectors[1];
                            bestSectors[2] = (tempi[i][3] < bestSectors[2]) ? tempi[i][3] : bestSectors[2];
                            bestSectors[3] = (tempi[i][4] < bestSectors[3]) ? tempi[i][4] : bestSectors[3];
                        }
                        const idealTime = bestSectors[0] + bestSectors[1] + bestSectors[2] + bestSectors[3]; 

                        let table = document.getElementById("res");
                        let heads = new Array(
                            "Tempo",
                            "T 1",
                            "T 2",
                            "T 3",
                            "T 4"
                            );
                        // stampa header della tabella
                        table.appendChild(document.createElement("tr"));
                        table.lastChild.appendChild(document.createElement("th"));
                        table.lastChild.lastChild.setAttribute("colspan", "5");
                        table.lastChild.lastChild.appendChild(document.createTextNode("Turno n. " + currentTurn++));

                        table.appendChild(document.createElement("tr"));
                        table.lastChild.appendChild(document.createElement("th"));
                        table.lastChild.lastChild.setAttribute("colspan", "5");
                        table.lastChild.lastChild.appendChild(document.createTextNode("Moto: " + moto));
                        
                        table.appendChild(document.createElement("tr"));
                        for(let i = 0; i < heads.length; i++){
                            table.lastChild.appendChild(document.createElement("th"));
                            table.lastChild.lastChild.appendChild(document.createTextNode(heads[i]));
                        }
                        // stampa i tempi
                        for(let i = 0; i < tempi.length; i++){
                            table.appendChild(document.createElement("tr"));
                            for(let j = 0; j < tempi[i].length; j++){
                                table.lastChild.appendChild(document.createElement("td"));
                                table.lastChild.lastChild.appendChild(document.createTextNode(parseMillis(tempi[i][j])));
                                if(tempi[i][0] == best)
                                    table.lastChild.firstChild.setAttribute("class", "best");
                            }
                            let sectors = table.lastChild.getElementsByTagName("td");
                            for(let k = 0; k < 4; k++){
                                if(tempi[i][k+1] == bestSectors[k])
                                    sectors[k+1].setAttribute("class", "best");
                            }
                        }
                        // stampa tempo ideale
                        table.appendChild(document.createElement("tr"));
                        table.lastChild.setAttribute("class", "ideal");
                        table.lastChild.appendChild(document.createElement("td"));
                        table.lastChild.lastChild.appendChild(document.createTextNode(parseMillis(idealTime)));
                        for(let i = 0; i < 4; i++){
                            table.lastChild.appendChild(document.createElement("td"));
                            table.lastChild.lastChild.appendChild(document.createTextNode(parseMillis(bestSectors[i])));
                        }
                        // table.lastChild.appendChild(document.createElement("td"));
                        // table.lastChild.lastChild.appendChild(document.createTextNode("Tempo Ideale"));
                    } else {
                        console.log(response);
                        let errMsg = "";
                        switch(response['err']){
                            case 0:
                                errMsg = document.getElementById("noData");
                                errMsg.hidden = false;
                                break;
                            case 1:
                                errMsg = document.getElementById("serverErr");
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

                return min + ':' + sec + '.' + dec;
            }
        </script>
    </body>
</html>