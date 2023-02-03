<?php
require '..\files\utility.php';
try {
    $pdo = connect();

    // se il form non e' completo
    if(empty($_POST["user"]) || empty($_POST["mail"]))
        throw new Exception(3);
    
    $user = $_POST["user"];
    $mail = $_POST["mail"];

    // verifico che l'username esista nel DB
    $query = "SELECT username
                FROM utente
                WHERE username = '".$user."'";
    $record = $pdo->query($query);
    $r = $record->fetch();

    if(!isset($r["username"]))
        throw new Exception(1);
    // verifico che la mail esista nel DB    
    $query = "SELECT email
                FROM utente
                WHERE email = '".$mail."'";
    $record = $pdo->query($query);
    $r = $record->fetch();

    if(!isset($r["email"]))
        throw new Exception(2);
    
    // verifico che username e email siano associati
    $query = "SELECT COUNT(*) AS c
                FROM utente
                WHERE username = \"$user\"
                AND email = \"$mail\"";
    $record = $pdo->query($query);
    $r = $record->fetch();

    if($r["c"] != 1)
        throw new Exception(4);

    $response = [
        'suitable' => true,
        'msg' => "Idoneo per recupero"
    ];

    session_start();
    // salvo il nome utente in sessione
    $_SESSION["user"] = $user;
} catch (Exception $e) {
    $response = [
        'suitable' => false,
        'error' => intval($e->getMessage())
    ];
} finally {
    echo json_encode($response);
    $pdo = null;
}
?>