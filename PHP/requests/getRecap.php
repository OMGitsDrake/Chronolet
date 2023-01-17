<?php
require '..\files\utility.php';

if(session_status() === PHP_SESSION_NONE)
    session_start();

try{
    if(!isset($_SESSION["user"]))
        throw new Exception("Qualcosa lato client e' andato storto!", 1);
        
    if(empty($_SESSION['user']))
        throw new Exception("Guest!", 2);


    $user = $_SESSION["user"];

    $pdo = connect();
    $query = "SELECT circuito, time_format(sec_to_time(min(t_lap)/1000), '%i:%s:%f') AS best
                FROM tempo
                WHERE pilota = \"$user\"
                GROUP BY circuito";
    $record = $pdo->query($query);
    
    if($record->rowCount() < 1)
        throw new Exception("Non ci sono abbastanza dati", 0);

    $recapArray = array();
    $i = 0;
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