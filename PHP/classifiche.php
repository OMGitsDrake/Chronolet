<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="..\img\podium.png">
    <link rel="stylesheet" href="..\CSS\menu.css">
    <title>Classifiche</title>
    <style>
        body {
            display: grid;
            place-items: center;
        }

        td.highlight {
            background-color: rgba(250, 0, 0, 0.7);
            color: white;
        }

        tr.awardable:nth-child(2) {
            background-color: goldenrod;
            color: chocolate;
        }

        tr.awardable:nth-child(3) {
            background-color: silver;
            color: gray;
        }
        
        tr.awardable:nth-child(4) {
            background-color: #cc4400;
            color: #802b00;
        }

        table{
            margin-top: 10px;
        }
    </style>
</head>
    <body>
        <fieldset>
            <legend>
                <img src="..\img\podium.png" alt="icon" width="64" height="64" style="display: inline;">
                <h1 style="display: inline; font-size: 50px;">Classifiche Piloti</h1>
            </legend>
            <input type="button" onclick="location.href='menu.php'" value="Indietro">
            <?php
            require __DIR__ . '\files\utility.php';
            
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            try{
                $user = isset($_SESSION['user']) ? $_SESSION['user'] : "";

                $pdo = connect();
            
                $sql = "SELECT C.nome
                        FROM circuito C
                        GROUP BY C.nome";
                $res = $pdo->query($sql);
                if ($res->rowCount() < 1)
                    throw new Exception;
                $i = 0;
                while($r = $res->fetch()){
                    $circuiti[$i] = $r['nome'];
                    $i++;
                }

                for ($i = 0; $i < count($circuiti); $i++){
                    $sql = "SELECT RANK() OVER(PARTITION BY D.circuito ORDER BY D.best_lap) AS posizione,
                            D.moto, D.pilota, D.`data`, D.best_lap
                            FROM(
                                SELECT pilota, `data`, moto, circuito, MIN(t_lap) AS best_lap
                                FROM tempo
                                GROUP BY pilota, circuito /*?, moto ?*/
                            ) AS D
                            WHERE D.circuito = \"$circuiti[$i]\"
                            LIMIT 50";
                    $set = $pdo->query($sql);
                    if($set->rowCount() < 1)
                        continue;

                    echo "<table>";
                    echo "<caption><h3>$circuiti[$i]</h3></caption>";
                    echo "<tr><th>Posizione</th>
                            <th>Moto</th>
                            <th>Pilota</th>
                            <th>Data</th>
                            <th>Tempo</th></tr>";
                    while($record = $set->fetch()){
                        if(!empty($user) && $record["pilota"] == $user)
                            echo "<tr class='awardable'><td class='highlight'>".$record["posizione"]."</td>
                                    <td>".$record["moto"]."</td>
                                    <td>".$record["pilota"]."</td>
                                    <td>".$record["data"]."</td>
                                    <td>".parse_millis($record["best_lap"])."</td></tr>";
                        else 
                            echo "<tr class='awardable'><td>".$record["posizione"]."</td>
                                    <td>".$record["moto"]."</td>
                                    <td>".$record["pilota"]."</td>
                                    <td>".$record["data"]."</td>
                                    <td>".parse_millis($record["best_lap"])."</td></tr>";
                    }
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
                    $mensile = $set->fetch();
                    echo "<tr><th colspan='5'>Best Mensile</th></tr>";
                    echo "<tr><td colspan='5'>".$mensile['pilota']." - ".$mensile['moto']." - ".parse_millis($mensile['best_lap'])."</td></tr>";
                    
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
                    $annuale = $set->fetch();
                    echo "<tr><th colspan='5'><h3>Best Annuale<h3></th></tr>";
                    echo "<tr><td colspan='5'>".$annuale['pilota']." - ".$annuale['moto']." - ".parse_millis($annuale['best_lap'])."</td></tr>";
                    echo "</div>";
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