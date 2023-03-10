<?php
require '..\files\utility.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    if($_POST['selezione_circuiti'] == "Scegli...")
        // dait mancanti
        throw new Exception("circuito non selezionato", 0);

    $user = $_SESSION['user'];
    $circuito = $_POST['selezione_circuiti'];
    $pdo = connect();

    // recupero la data
    $sql = "SELECT max(`data`) AS last_date
            FROM tempo
            WHERE pilota = \"$user\"
            AND circuito = \"$circuito\"";

    $set = $pdo->query($sql);

    $data = $set->fetch();

    // recupero i tempi e la moto
    $sql = "SELECT moto, t_lap, t_s1, t_s2, t_s3, t_s4
            FROM tempo 
            WHERE `data` >= ALL(
                SELECT `data`
                FROM tempo
                WHERE pilota = \"$user\"
                AND circuito = \"$circuito\"
            )
            AND pilota = \"$user\"
            AND circuito = \"$circuito\"";
    
    $set = $pdo->query($sql);
    if ($set->rowCount() < 1)
        // DB vuoto
        throw new Exception("Non ci sono dati relativi al circuito selezionato!", 1);

    $times = array();
    $i = 0;
    while($r = $set->fetch()){
        $times[$i][0] = $r['moto'];
        $times[$i][1] = $r['t_lap'];
        $times[$i][2] = $r['t_s1'];
        $times[$i][3] = $r['t_s2'];
        $times[$i][4] = $r['t_s3'];
        $times[$i][5] = $r['t_s4'];
        $i++;
    }

    $res = [
        'ok' => true,
        'circuit' => $circuito,
        'date' => $data['last_date'],
        'times' => $times,
        'msg' => "dati ricevuti correttamente"
    ];
} catch (Exception $e) {
    $res = [
        'ok' => false,
        'msg' => $e->getMessage(),
        'err' => $e->getCode()
    ];
} finally {
    echo json_encode($res);
    $pdo = null;
}
?>