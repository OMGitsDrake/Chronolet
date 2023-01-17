<?php
require '..\files\utility.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    $pdo = connect();

    if($_SESSION['logged'] === false){
        if ($_POST['selezione_circuito'] === "Seleziona Circuito" || $_POST['selezione_moto'] === "Seleziona Moto")
            throw new Exception("Dati richiesti!", 0);
        $tempi = array();
        $giri = rand(1, 15);
        $circuito = $_POST['selezione_circuito'];
        $moto = $_POST['selezione_moto'];
        
        for ($i = 0; $i < $giri; $i++){
            $tempi[$i] = generate_time($circuito);
            if ($tempi[$i] === -1)
                throw new Exception("Qualcosa e' andato storto!", 1);
        }
    
        $response = [
            'ok' => true,
            'tempi' => $tempi,
            'moto' => $moto,
            'msg' => "Tempi Registrati!"
        ];
    } else {
        if ($_POST['selezione_circuito'] === "Seleziona Circuito" || $_POST['selezione_moto'] === "Seleziona Moto")
            throw new Exception("Dati richiesti!", 0);
    
        $pilota = $_SESSION['user'];
        $circuito = $_POST['selezione_circuito'];
        $moto = $_POST['selezione_moto'];
    
        $tempi = array();
        $giri = rand(1, 15);
        $sql = "INSERT INTO tempo(pilota, moto, circuito, `data`, t_lap, t_s1, t_s2, t_s3, t_s4)
                VALUES(?, ?, ?, current_date(), ?, ?, ?, ?, ?)";
    
        for ($i = 0; $i < $giri; $i++){
            $tempi[$i] = generate_time($circuito);
            if ($tempi[$i] === -1)
                throw new Exception("Qualcosa e' andato storto!", 1);
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $pilota);
            $statement->bindValue(2, $moto);
            $statement->bindValue(3, $circuito);
            $statement->bindValue(4, $tempi[$i][0]);
            $statement->bindValue(5, $tempi[$i][1]);
            $statement->bindValue(6, $tempi[$i][2]);
            $statement->bindValue(7, $tempi[$i][3]);
            $statement->bindValue(8, $tempi[$i][4]);
            $statement->execute();
        }
    
        $response = [
            'ok' => true,
            'tempi' => $tempi,
            'moto' => $moto,
            'msg' => "Tempi Registrati!"
        ];
    }
} catch (Exception $e) {
    $response = [
        'ok' => false,
        'msg' => "Inserimento tempi fallito! (".$e->getMessage().")",
        'err' => $e->getCode()
    ];
} finally {
    echo json_encode($response);
    $pdo = null;
}
?>