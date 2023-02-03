<?php
    require '..\files\utility.php';
    
    try {
        session_start();

        $user = $_SESSION["user"];
        $answer = strtolower($_POST["answer"]);
        $psw = $_POST["psw"];
        $re_psw = $_POST["re_psw"];

        $pdo = connect();

        // recupero la risposta dell'utente
        $query = "SELECT risposta
                    FROM utente
                    WHERE username = \"$user\"";
        $record = $pdo->query($query);
        $r = $record->fetch();

        // se la risposta e' sbagliata
        if($r["risposta"] != $answer)
            throw new Exception(1);
        
        // se le pasword non coincidono
        if($psw != $re_psw)
            throw new Exception(2);
        
        // aggiorno il record dell'utente
        $sql = "UPDATE utente
                SET `password` = ?
                WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, password_hash($psw, PASSWORD_BCRYPT));
        $stmt->bindValue(2, $user);

        $stmt->execute();

        $response = [
            'ok' => true,
            'msg' => 'Operazione riuscita!'
        ];

    } catch (Exception $e) {
        $response = [
            'ok' => false,
            'msg' => $e->getMessage(),
            'err' => intval($e->getMessage())
        ];
    } finally {
        echo json_encode($response);
        $pdo = null;
        unset($_SESSION);
    }
?>