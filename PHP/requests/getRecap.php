<?php
require '..\files\utility.php';

if(session_status() === PHP_SESSION_NONE)
    session_start();

try{
    if(!isset($_SESSION["user"]))
        throw new Exception("Qualcosa lato client e' andato storto!", 1);
    // se accedo in modalita' guest visualizzero' un messaggio che mi avverte che la funzione non e' disponibile
    if(empty($_SESSION['user']))
        throw new Exception("Guest!", 2);


    $user = $_SESSION["user"];

    $pdo = connect();
    // recupero circuito e miglior tempo
    $query = "SELECT circuito, min(t_lap) AS best
                FROM tempo
                WHERE pilota = \"$user\"
                GROUP BY circuito";
    $record = $pdo->query($query);
    
    if($record->rowCount() < 1)
        // se non ho nessun giro registrato lo comunico all'utente
        throw new Exception("Non ci sono abbastanza dati", 0);

    $recapArray = array();
    $i = 0;
    // organizzo il risultato con un array associativo
    // Circuito:{c1, c2, ..., cn}
    // Miglior Tempo:{b1, b2, ..., bn}
    while($r = $record->fetch()){
        $recapArray["circuito"][$i] = $r["circuito"];
        $recapArray["best"][$i] = $r["best"];    
        $i++;
    }
    
    $response = [
        'ok' => true,
        'msg'=> $recapArray
    ];
} catch (Exception $e) {
    $response = [
        'ok' => false,
        'msg' => $e->getMessage(),
        'error' => $e->getCode()
    ];
} finally {
    echo json_encode($response);
    $pdo = null;
}
?>