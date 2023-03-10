<?php
    require '..\files\utility.php';
    try {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $pdo = connect();

        // se mancano i campi
        if(empty($_POST["user"]) || empty($_POST["pswd"]))
            throw new Exception("Dati richiesti!", 0);

        $user = $_POST["user"];
        $psw = $_POST["pswd"];
        
        // recupero l'hash della password per verificare l'accesso
        $sql = "SELECT `password` FROM utente WHERE username = \"$user\"";
        $record = $pdo->query($sql);
        $res = $record->fetch();
        if(!$res){
            throw new Exception("User not found!", 1);
        }
        
        // verifico l'hash della password con quello inviato dall'utente
        if(password_verify($psw, $res["password"])){
            $_SESSION["user"] = $user;
            $_SESSION["logged"] = true;
            
            $response = [
                'logged' => true,
                'user' => $user,
                'msg' => 'Accesso avvenuto!'
            ];
        } else 
            throw new Exception("Passowrd errata!", 2);
            
    } catch (Exception $e) {
        $response = [
            'logged' => false,
            'msg' => 'Accesso fallito! -> '. $e->getMessage(),
            'error' => $e->getCode()
        ];
    } finally {
        echo json_encode($response);
        $pdo = null;
    }
?>