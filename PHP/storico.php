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

                $sql = "SELECT C.nome
                        FROM circuito C
                        GROUP BY C.nome";
                $res = $pdo->query($sql);
                $i = 0;
                while($r = $res->fetch()){
                    $circuiti[$i] = $r['nome'];
                    $i++;
                }

                echo "<h2>Storico tempi di ". $_SESSION["user"] ."</h2>";
                for ($i = 0; $i < count($circuiti); $i++){
                    $sql = "SELECT moto, `data`, t_lap, t_s1, t_s2, t_s3, t_s4 
                            FROM tempo
                            WHERE pilota = \"".$_SESSION['user']."\"
                                AND circuito = \"".$circuiti[$i]."\"
                            ORDER BY `data`, circuito";
                    $set = $pdo->query($sql);
                    echo "<table>";
                    echo "<caption>".$circuiti[$i]."</caption>";
                    echo "<tr>
                            <th>Moto</th>
                            <th>Data</th>
                            <th>Tempo sul Giro</th>
                            <th>T1</th>
                            <th>T2</th>
                            <th>T3</th>
                            <th>T4</th>
                            <tr>";
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
            <input type="button" onclick="location.href='menu.php'" value="Indietro">
        </div>
    </body>
</html>