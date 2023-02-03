<?php
require '..\files\utility.php';

try {
    $pdo = connect();

    // campi mancanti
    if(empty($_POST["user"]) || empty($_POST["pswd"]) || empty($_POST["re_pswd"]) || empty($_POST["mail"]) || ($_POST["question"] === "Scegli...")
        || empty($_POST["answer"]))
        throw new Exception("Dati richiesti!", 2);

    $user = $_POST["user"];
    $pswd = password_hash($_POST["pswd"], PASSWORD_BCRYPT);
    $re_pswd = $_POST["re_pswd"];
    $mail = $_POST["mail"];
    $question = $_POST["question"];
    $answer = strtolower($_POST["answer"]);

    // controllo che le password siano uguali
    if(!password_verify($re_pswd, $pswd))
        throw new Exception("Le password non coincidono!", 0);

    // controllo se il nome utente e' disponibile
    $query = "SELECT username FROM utente";
    $record = $pdo->query($query);

    while($r = $record->fetch())
        if(($user === $r["username"]))
            throw new Exception("Nome utente non disponibile!", 1);
    
    // registro l'utente
    $sql = "INSERT INTO utente VALUES(?, ?, ?, ?, ?)";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(1, $user);
    $statement->bindValue(2, $pswd);
    $statement->bindValue(3, $mail);
    $statement->bindValue(4, $question);
    $statement->bindValue(5, $answer);
    $statement->execute();
    
    $response = [
        'sign' => true,
        'user' => $user,
        'msg' => 'Registrazione avvenuta!'
    ];
} catch (Exception $e) {
    $response = [
        'sign' => false,
        'msg' => 'Registrazione fallita! -> '. $e->getMessage(),
        'error' => $e->getCode()
    ];
} finally {
    echo json_encode($response);
    $pdo = null;
}
?>