<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/podium.png">
    <link rel="stylesheet" href="../CSS/menu.css">
    <title>Classifiche</title>
    <style>
        /**
            La classe seguente evidenzia la riga della tabella in cui e' presente l'utente
        */
        td.highlight {
            background-color: rgba(250, 0, 0, 0.7);
            color: white;
        }

        /**
            La classe seguente colora i primi tre posti in classifica
            con i colori dei primi tre posti del podio (oro, argento, bronzo)
        */
        tr.awardable:nth-child(3) {
            background-color: goldenrod;
            color: chocolate;
        }

        tr.awardable:nth-child(4) {
            background-color: silver;
            color: gray;
        }
        
        tr.awardable:nth-child(5) {
            background-color: #cc4400;
            color: #802b00;
        }

        table{
            margin-top: 20px;
        }
    </style>
</head>
    <body>
        <fieldset>
            <legend>
                <img src="../img/podium.png" alt="icon" width="64" height="64" style="display: inline;">
                <h1 style="display: inline; font-size: 50px;">Classifiche Piloti</h1>
            </legend>
            <input type="button" onclick="location.href='menu.php'" value="Indietro">
            <?php
            require __DIR__ . '\files\utility.php';
            
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            isLogged();

            try{
                $user = isset($_SESSION['user']) ? $_SESSION['user'] : "";

                $pdo = connect();
                
                // recupero i circuiti
                $sql = "SELECT C.nome
                        FROM circuito C
                        GROUP BY C.nome";
                $res = $pdo->query($sql);
                if ($res->rowCount() < 1)
                    // DB vuoto
                    throw new Exception;
                $i = 0;
                while($r = $res->fetch()){
                    $circuiti[$i] = $r['nome'];
                    $i++;
                }

                // per ogni circuito recupero il record con il miglior tempo (e settori) e il rispettivo pilota
                for ($i = 0; $i < count($circuiti); $i++){
                    // classifica piloti
                    $sql = "SELECT RANK() OVER(PARTITION BY D.circuito ORDER BY D.best_lap) AS posizione,
                            D.moto, D.pilota, D.`data`, D.best_lap
                            FROM(
                                SELECT pilota, `data`, moto, circuito, MIN(t_lap) AS best_lap
                                FROM tempo
                                GROUP BY pilota, circuito
                            ) AS D
                            WHERE D.circuito = \"$circuiti[$i]\"
                            LIMIT 50";
                    $set = $pdo->query($sql);
                    if($set->rowCount() < 1)
                        continue;

                    // stampo a video la tabella
                    echo "<table>";
                    echo "<tr><td class='caption' colspan='5'>$circuiti[$i]</td></tr>";
                    echo "<tr><th>Posizione</th>
                            <th>Moto</th>
                            <th>Pilota</th>
                            <th>Data</th>
                            <th>Tempo</th></tr>";
                    while($record = $set->fetch()){
                        // le righe della tabella che formano il podio
                        // verranno colorate grazie alla classe css "awardable"
                        if(!empty($user) && $record["pilota"] == $user)
                            // se l'utente ha fatto il tempo i-esimo, verra' evidenziato
                            // per una miglior visualizzazione con la classe csss highlight
                            echo "<tr class='awardable'>
                                    <td class='highlight'>".$record["posizione"]."</td>
                                    <td>".$record["moto"]."</td>
                                    <td>".$record["pilota"]."</td>
                                    <td>".$record["data"]."</td>
                                    <td>".parse_millis($record["best_lap"])."</td></tr>";
                        else 
                            echo "<tr class='awardable'>
                                    <td>".$record["posizione"]."</td>
                                    <td>".$record["moto"]."</td>
                                    <td>".$record["pilota"]."</td>
                                    <td>".$record["data"]."</td>
                                    <td>".parse_millis($record["best_lap"])."</td></tr>";
                    }
                    // miglior tempo fatto nel mese corrente
                    $sql = "SELECT D1.pilota, D1.moto, D1.best_lap
                            FROM (	
                                SELECT RANK() OVER(PARTITION BY D.circuito ORDER BY D.best_lap) AS posizione, D.moto, D.pilota, D.`data`, D.best_lap
                                FROM(
                                    SELECT pilota, `data`, moto, circuito, MIN(t_lap) AS best_lap
                                    FROM tempo
                                    GROUP BY pilota, circuito, moto
                                ) AS D
                                WHERE D.circuito = \"$circuiti[$i]\"
                            ) AS D1
                            WHERE MONTH(D1.`data`) = MONTH(current_date())
                            LIMIT 1";
                    $set = $pdo->query($sql);
                    if($set->rowCount() >= 1){
                        $mensile = $set->fetch();
                        echo "<tr><th colspan='5'>Best Mensile</th></tr>";
                        echo "<tr><td colspan='5'>".$mensile['pilota']." - ".$mensile['moto']." - ".parse_millis($mensile['best_lap'])."</td></tr>";
                    }
                    
                    // miglior tempo fatto nell'anno corrente
                    $sql = "SELECT D1.pilota, D1.moto, D1.best_lap
                            FROM (	
                                SELECT RANK() OVER(PARTITION BY D.circuito ORDER BY D.best_lap) AS posizione, D.moto, D.pilota, D.`data`, D.best_lap
                                FROM(
                                    SELECT pilota, `data`, moto, circuito, MIN(t_lap) AS best_lap
                                    FROM tempo
                                    GROUP BY pilota, circuito, moto
                                ) AS D
                                WHERE D.circuito = \"$circuiti[$i]\"
                            ) AS D1
                            WHERE YEAR(D1.`data`) = YEAR(current_date())
                            LIMIT 1";
                    $set = $pdo->query($sql);
                    if($set->rowCount() >= 1){
                        $annuale = $set->fetch();
                        echo "<tr><th colspan='5'>Best Annuale</th></tr>";
                        echo "<tr><td colspan='5'>".$annuale['pilota']." - ".$annuale['moto']." - ".parse_millis($annuale['best_lap'])."</td></tr>";
                    }
                    echo "</table>";
                }
            } catch(Exception $e){
                echo $messages['emptyDB'];
            } finally {
                $pdo = null;
            }
            ?>
        </fieldset>
    </body>
</html>