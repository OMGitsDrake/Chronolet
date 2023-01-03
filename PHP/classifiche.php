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
            // TODO best mensile, annuale
            require __DIR__ . '\files\utility.php';
            try{
                session_start();
                
                echo "<h1>Classifiche Piloti</h1>";
                echo "<h3>Circuito</h3>";
                
                $pdo = connect();
            
                $sql = "SELECT RANK() OVER(PARTITION BY D.circuito ORDER BY D.best_lap) AS posizione,
                        D.moto, D.pilota, D.`data`,  D.circuito, D.best_lap, D.t_s1, D.t_s2, D.t_s3, D.t_s4
                        FROM(
                            SELECT pilota, `data`, moto, circuito, MIN(t_lap) AS best_lap, t_s1, t_s2, t_s3, t_s4
                            FROM tempo
                            GROUP BY pilota, circuito, moto
                        ) AS D
                        ORDER BY D.circuito";
                $set = $pdo->query($sql);
                if($set->rowCount() < 1){
                    echo $messages["emptyDB"];
                    echo "<input type='button' onclick='location.href=\"menu.php\"' value='Indietro'>";
                    $pdo = null;
                    exit;
                }

                echo "<table>";
                echo "<tr><th>Posizione</th>
                        <th>Moto</th>
                        <th>Pilota</th>
                        <th>Circuito</th>
                        <th>Data</th>
                        <th>Tempo</th>
                        <th>T1</th>
                        <th>T2</th>
                        <th>T3</th>
                        <th>T4</th><tr>";
                while($record = $set->fetch()){
                    if(isset($_SESSION["user"]) && $record["pilota"] == $_SESSION["user"])
                        echo "<tr class='highlight'><td>".$record["posizione"]."</td>
                                <td>".$record["moto"]."</td>
                                <td>".$record["pilota"]."</td>
                                <td>".$record["data"]."</td>
                                <td>".$record["circuito"]."</td>
                                <td>".parse_millis($record["best_lap"])."</td>
                                <td>".parse_millis($record["t_s1"])."</td>
                                <td>".parse_millis($record["t_s2"])."</td>
                                <td>".parse_millis($record["t_s3"])."</td>
                                <td>".parse_millis($record["t_s4"])."</td></tr>";
                    else 
                        echo "<tr><td>".$record["posizione"]."</td>
                                <td>".$record["moto"]."</td>
                                <td>".$record["pilota"]."</td>
                                <td>".$record["data"]."</td>
                                <td>".$record["circuito"]."</td>
                                <td>".parse_millis($record["best_lap"])."</td>
                                <td>".parse_millis($record["t_s1"])."</td>
                                <td>".parse_millis($record["t_s2"])."</td>
                                <td>".parse_millis($record["t_s3"])."</td>
                                <td>".parse_millis($record["t_s4"])."</td></tr>";
                }
                echo "</table>";

                echo "<h3>Moto - Circuito</h3>";
                
                $sql = "SELECT RANK() OVER(PARTITION BY D.moto, D.circuito ORDER BY D.best_lap) AS posizione, D.moto,
                        D.pilota, D.`data`,  D.circuito, D.best_lap, D.t_s1, D.t_s2, D.t_s3, D.t_s4
                        FROM(
                            SELECT pilota, `data`, moto, circuito, MIN(t_lap) AS best_lap, t_s1, t_s2, t_s3, t_s4
                            FROM tempo
                            GROUP BY pilota, circuito, moto
                        ) AS D
                        ORDER BY D.circuito";
                
                $set = $pdo->query($sql);

                echo "<table>";
                echo "<tr><th>Posizione</th>
                        <th>Pilota</th>
                        <th>Moto</th>
                        <th>Circuito</th>
                        <th>Data</th>
                        <th>Tempo</th>
                        <th>T1</th>
                        <th>T2</th>
                        <th>T3</th>
                        <th>T4</th><tr>";
                while($record = $set->fetch()){
                    if(isset($_SESSION["user"]) && $record["pilota"] == $_SESSION["user"])
                        echo "<tr class='highlight'><td>".$record["posizione"]."</td>
                                <td>".$record["moto"]."</td>
                                <td>".$record["pilota"]."</td>
                                <td>".$record["data"]."</td>
                                <td>".$record["circuito"]."</td>
                                <td>".parse_millis($record["best_lap"])."</td>
                                <td>".parse_millis($record["t_s1"])."</td>
                                <td>".parse_millis($record["t_s2"])."</td>
                                <td>".parse_millis($record["t_s3"])."</td>
                                <td>".parse_millis($record["t_s4"])."</td></tr>";
                    else
                        echo "<tr><td>".$record["posizione"]."</td>
                                <td>".$record["moto"]."</td>
                                <td>".$record["pilota"]."</td>
                                <td>".$record["data"]."</td>
                                <td>".$record["circuito"]."</td>
                                <td>".parse_millis($record["best_lap"])."</td>
                                <td>".parse_millis($record["t_s1"])."</td>
                                <td>".parse_millis($record["t_s2"])."</td>
                                <td>".parse_millis($record["t_s3"])."</td>
                                <td>".parse_millis($record["t_s4"])."</td></tr>";
                }
                echo "</table>";
            } catch(Exception $e){
                die($e->getMessage());
            }
        ?>

        <input type="button" onclick="location.href='menu.php'" value="Indietro">
    </body>
</html>