<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/history.png">
    <link rel="stylesheet" href="../CSS/menu.css">
        <style>
            h1{
                font-style: italic;
                font-family: 'Trebuchet MS';
                font-size: 50px;
                text-decoration: underline #0066ff;
                color: #803300;
            }
            
            .container{
                display: grid;
                column-gap: 10px;
                row-gap: 10px;
                grid-template-columns: repeat(2, 1fr);
                align-items: stretch;
                justify-items: center;
            }

            table{
                font-size: 18px;
            }
        </style>
    <title>Storico Tempi</title>
</head>
    <body>
            <div>
                <img  src="../img/history.png" alt="icon" width="64" height="64" style="display: inline;">
            <?php 
            require __DIR__ . '\files\utility.php';
            
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            isLogged();

            try {
                $user = $_SESSION["user"];

                $pdo = connect();

                // recupero i circuiti
                $sql = "SELECT C.nome
                        FROM circuito C
                        GROUP BY C.nome";
                $res = $pdo->query($sql);
                $i = 0;
                while($r = $res->fetch()){
                    $circuiti[$i] = $r['nome'];
                    $i++;
                }

                // display dell'interfaccia
                echo "<h1 style='display: inline;'>Storico tempi di $user</h1>";
                echo "</div>";
                echo "<input style='margin-bottom: 1%; margin-top: 1%;' type='button' onclick='location.href=\"menu.php\"' value='Indietro'>";
                echo "<div class='container'>";
                for ($i = 0; $i < count($circuiti); $i++){
                    // per ogni circuito recupero i dati relativi all'utente
                    $sql = "SELECT moto, `data`, t_lap, t_s1, t_s2, t_s3, t_s4 
                            FROM tempo
                            WHERE pilota = \"$user\"
                                AND circuito = \"$circuiti[$i]\"
                            ORDER BY `data`, circuito";
                    $set = $pdo->query($sql);
                    if ($set->rowCount() < 1)
                        // se non vi sono dati per un circuito, viene saltato
                        continue;
                    echo "<table class='gridItem'>";
                    echo "<tr><td class='caption' colspan='7'>$circuiti[$i]</td></tr>";
                    echo "<tr>
                            <th>Moto</th>
                            <th>Data</th>
                            <th>Tempo sul Giro</th>
                            <th>T1</th>
                            <th>T2</th>
                            <th>T3</th>
                            <th>T4</th>
                            </tr>";
                    while($record = $set->fetch()){
                        echo "<tr>
                                <td>".$record["moto"]."</td>
                                <td>".$record["data"]."</td>
                                <td>".parse_millis($record["t_lap"])."</td>
                                <td>".parse_millis($record["t_s1"])."</td>
                                <td>".parse_millis($record["t_s2"])."</td>
                                <td>".parse_millis($record["t_s3"])."</td>
                                <td>".parse_millis($record["t_s4"])."</td>
                                </tr>";
                    }
                    echo "</table>";
                }
            } catch (Exception $e) {
                echo $messages['emptyDB'];
            } finally {
                $pdo = null;
            }
            ?>
        </div>
    </body>
</html>