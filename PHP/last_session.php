<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ultima Sessione</title>
</head>
    <body>
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

                echo "<form action='last_session.php' method='POST'>";
                echo "<select name='selezione_circuiti' id='circuito'>";        
                echo "<option>Seleziona Circuito</option>";
                while($record = $set->fetch()){
                    echo "<option>".$record["nome"]."</option>";
                }
                echo "</select>";

                echo "<input type='submit' value='Seleziona'>";
                echo "</form>";
                // TODO: da fare in asincrono
                if(isset($_POST["selezione_circuiti"]) && $_POST["selezione_circuiti"] != "Seleziona Circuito"){
                    $sql = "SELECT *
                    FROM tempo 
                    WHERE `data` >= ALL(
                                SELECT `data`
                                FROM tempo
                                WHERE pilota = \"" . $_SESSION["user"] . "\"
                                AND circuito = \"" . $_POST["selezione_circuiti"] ."\"
                            )
                            AND pilota = \"" . $_SESSION["user"] . "\"
                            AND circuito = \"" . $_POST["selezione_circuiti"] ."\"";

                    $set = $pdo->query($sql);
                    if ($set->rowCount() < 1)
                        throw new Exception(1);

                    echo "<table>";
                    echo "<tr><th>Moto</th>
                            <th>Circuito</th>
                            <th>Data</th>
                            <th>Tempo</th>
                            <th>T1</th>
                            <th>T2</th>
                            <th>T3</th>
                            <th>T4</th><tr>";
                    while($record = $set->fetch()){
                        echo "<tr><td>".$record["moto"]."</td>
                                <td>".$record["circuito"]."</td>
                                <td>".$record["data"]."</td>
                                <td>".parse_millis($record["t_lap"])."</td>
                                <td>".parse_millis($record["t_s1"])."</td>
                                <td>".parse_millis($record["t_s2"])."</td>
                                <td>".parse_millis($record["t_s3"])."</td>
                                <td>".parse_millis($record["t_s4"])."</td></tr>";
                    }
                    echo "</table>";
                } else {
                    // TODO: session exception
                }
            } catch(Exception $e){
                switch(intval($e->getCode())){
                    case 0:
                        echo $messages["emptyDB"];
                        break;
                    case 1:
                        echo "<h2>Non ci sono ancora dati relativi al circuito selezionato!<br>
                                Inizia una Sessione cronometrata per vedere i tuoi tempi</h2>";
                        break;
                    }
            } finally {
                $pdo = null;
            }
        ?>

        <input type="button" onclick="location.href='menu.php'" value="Indietro">
    </body>
    <script>
        const form = document.getElementById("circuitData");

        form.onsubmit = reqData;

        function reqData(event){
            event.preventDefault();

            let data = new FormData(form);
            let x = new XMLHttpRequest();
            x.open("POST", "getCircuitData.php");

            x.onload = () => {
                const response = JSON.parse(x.response);
                if(/*ok*/){

                } else {

                }
            }

            x.onerror = (event) => console.log(event);
            x.send(data);
        }
    </script>
</html>