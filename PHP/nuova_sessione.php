<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuova Sessione</title>
    <style>
        td#best{
            background-color: rgba(250, 0, 0, 0.5);
            color: white;
        }
    </style>
</head>
    <body>
        <fieldset>
            <legend><h1>Nuova Sessione Cronometrata</h1></legend>        
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
                    throw new Exception();
                
                echo "<select name='selezione_circuito' id='circuito'>";        
                echo "<option>Seleziona Circuito</option>";
                while($record = $set->fetch()){
                    echo "<option>".$record["nome"]."</option>";
                }
                echo "</select>";
        
                $sql = "SELECT marca, modello FROM archiviomoto";
                $set = $pdo->query($sql);
                if($set->rowCount() < 1)
                    throw new Exception();
                
                echo "<select name='selezione_moto' id='moto'>";
                echo "<option>Seleziona Moto</option>";        
                while($record = $set->fetch()){
                    echo "<option>".$record["marca"]." ".$record["modello"]."</option>";
                }
                echo "<option>Altro...</option>";
                echo "</select>";
                
                /**
                 * inviare tramite form una richiesta POST a uno script php che:
                 * - calcola i tempi per giro
                 * - scrive nal db i tempi dell'utente
                 * - invia una risposta a questa pagina
                 * - qui con la then della promessa js stampo i risultati
                 * 
                 * • i dati nella response sono un array codificato json
                 * • gestire errori
                 */
                echo "<input type='button' value='Avvia' onclick='avviaSessione()'>";
            } catch(Exception $e){
                echo $messages["emptyDB"];
                echo "<input type='button' onclick='location.href=\"menu.php\"' value='Indietro'>";
            } finally {
                $pdo = null;
            }
        ?>
        <p class="err" id="noData" hidden>Entrambi i campi richiesti sono obbligatori!</p>
        </fieldset>
        <table id="res"></table>
        <button id="save" hidden>Salva</button>
        <input type="button" onclick="location.href='menu.php'" value="Indietro">
        <script src="../JS/crono_session.js"></script>
    </body>
</html>