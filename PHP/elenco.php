<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elenco Circuiti</title>
</head>
<body>
    <h1>Elenco dei Circuiti Disponibili</h1>
    <?php
        require __DIR__ . '\files\utility.php';

        try{
            $pdo = connect();
        
            $sql = "SELECT * FROM circuito";
            $set = $pdo->query($sql);
            if($set->rowCount() < 1){
                echo $messages["emptyDB"];
                echo "<input type='button' onclick='location.href=\"menu.php\"' value='Indietro'>";
                $pdo = null;
                exit;
            }
            echo "<table>";
            echo "<tr><th>Nome</th>
                    <th>Località</th>
                    <th>Lunghezza</th><tr>";
            while($record = $set->fetch()){
                echo "<tr><td>".$record["nome"]."</td>
                        <td>".$record["localita"]."</td>
                        <td>".$record["lunghezza"]." m"."</td></tr>";
            }
            echo "</table>";
            $pdo = null;
        } catch(PDOException $e){
            $pdo = null;
            die($e->getMessage());
        }
    ?>
    <input type="button" onclick="location.href='menu.php'" value="Indietro">
</body>
</html>