<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classifiche</title>
    <style>
        .highlight{
            background-color: rgba(250, 0, 0, 0.7);
            color: white;
        }
    </style>
</head>
    <body>
        <?php
        require __DIR__ . '\files\utility.php';
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        try{
            echo "<h1>Classifiche Piloti</h1>";

            $user = isset($_SESSION['user']) ? $_SESSION['user'] : "";

            $pdo = connect();
        
            $sql = "SELECT C.nome
                    FROM circuito C
                    GROUP BY C.nome";
            $res = $pdo->query($sql);
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
                            GROUP BY pilota, circuito, moto
                        ) AS D
                        WHERE D.circuito = \"$circuiti[$i]\"";
                $set = $pdo->query($sql);
                if($set->rowCount() < 1)
                    throw new Exception;

                echo "<table>";
                echo "<caption><h3>$circuiti[$i]</h3></caption>";
                echo "<tr><th>Posizione</th>
                        <th>Moto</th>
                        <th>Pilota</th>
                        <th>Data</th>
                        <th>Tempo</th></tr>";
                while($record = $set->fetch()){
                    if(!empty($user) && $record["pilota"] == $user)
                        echo "<tr><td class='highlight'>".$record["posizione"]."</td>
                                <td>".$record["moto"]."</td>
                                <td>".$record["pilota"]."</td>
                                <td>".$record["data"]."</td>
                                <td>".parse_millis($record["best_lap"])."</td></tr>";
                    else 
                        echo "<tr><td>".$record["posizione"]."</td>
                                <td>".$record["moto"]."</td>
                                <td>".$record["pilota"]."</td>
                                <td>".$record["data"]."</td>
                                <td>".parse_millis($record["best_lap"])."</td></tr>";
                }
                echo "</table>";
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
                echo "<div>";
                echo "<h3>Best Mensile<h3>";
                echo "<p>".$mensile['pilota']." - ".$mensile['moto']." - ".parse_millis($mensile['best_lap'])."</p>";
                
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
                echo "<h3>Best Annuale<h3>";
                echo "<p>".$annuale['pilota']." - ".$annuale['moto']." - ".parse_millis($annuale['best_lap'])."</p>";
                echo "</div>";
            }
        } catch(Exception $e){
            echo $messages['emptyDB'];
        } finally {
            $pdo = null;
        }
        ?>
        <input type="button" onclick="location.href='menu.php'" value="Indietro">
    </body>
</html>