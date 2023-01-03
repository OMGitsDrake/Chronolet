<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storico Tempi</title>
</head>
    <body>
        <div class="container">
            <?php 
                require __DIR__ . '\files\utility.php';
                
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                try {
                    $pdo = connect();

                    $sql = "SELECT *
                            FROM tempo
                            WHERE pilota = "."'".$_SESSION["user"]."'
                            ORDER BY circuito, moto";
                    $set = $pdo->query($sql);

                    if($set->rowCount() < 1){
                        echo $messages["emptyDB"];
                        echo "<input type='button' onclick='location.href=\"menu.php\"' value='Indietro'>";
                        $pdo = null;
                        exit;
                    }
                    echo "<h2>Storico tempi di ". $_SESSION["user"] ."</h2>";
                    echo "<table>";
                    echo "<tr><th>Circuito</th>
                            <th>Moto</th>
                            <th>Data</th>
                            <th>Tempo sul Giro</th>
                            <th>T1</th>
                            <th>T2</th>
                            <th>T3</th>
                            <th>T4</th><tr>";
                    while($record = $set->fetch()){
                        echo "<tr><td>".$record["circuito"]."</td>
                                <td>".$record["moto"]."</td>
                                <td>".$record["data"]."</td>
                                <td>".parse_millis($record["t_lap"])."</td>
                                <td>".parse_millis($record["t_s1"])."</td>
                                <td>".parse_millis($record["t_s2"])."</td>
                                <td>".parse_millis($record["t_s3"])."</td>
                                <td>".parse_millis($record["t_s4"])."</td></tr>";
                            }
                    echo "</table>";
                    $pdo = null;
                } catch (PDOException $e) {
                    die($e->getMessage());
                }
            ?>
            <input type="button" onclick="location.href='menu.php'" value="Indietro">
        </div>
        
    </body>
</html>