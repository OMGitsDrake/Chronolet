<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\CSS\menu.css">
    <link rel="icon" type="image/x-icon" href="..\img\circuit.png">
    <title>Elenco Circuiti</title>
    <style>
        h1{
            color: #803300;
            font-family: Trebuchet MS;
            font-style: italic;
            font-size: 40px;
        }
    </style>
</head>
<body>
    <fieldset>
        <legend>
            <img src="..\img\circuit.png" alt="stopwatch_icon" width="64" height="64" style="display: inline;">
            <h1 style="display: inline;">Elenco dei Circuiti Disponibili</h1>
        </legend>
        <?php
            require __DIR__ . '\files\utility.php';

            try{
                $pdo = connect();
            
                $sql = "SELECT * FROM circuito";
                $set = $pdo->query($sql);
                if($set->rowCount() < 1)
                    throw new Exception("Sito in manutenzione!");
                
                echo "<table>";
                echo "<tr><th>Nome</th>
                        <th>Località</th>
                        <th>Lunghezza</th>
                        <th colspan='2'>Link</th>
                        </tr>";
                while($record = $set->fetch()){
                    echo "<tr><td>".$record["nome"]."</td>
                            <td>".$record["localita"]."</td>
                            <td>".$record["lunghezza"]." m"."</td>
                            <td><a href='".$record["urlmaps"]."' target='_blank'><img src='../img/maps.png' alt='Maps' style='width:24px;height:24px;'></a></td>
                            <td><a href='".$record["urlsito"]."' target='_blank'><img src='../img/website.png' alt='Sito Web' style='width:24px;height:24px;'></a></td>
                            </tr>";
                }
                echo "</table>";
            } catch(PDOException $e){
                echo "<h2>".$e->getMessage()."</h2>";
            } finally {
                $pdo = null;
            }
        ?>
        <input type="button" onclick="location.href='menu.php'" value="Indietro">
    </fieldset>
</body>
</html>