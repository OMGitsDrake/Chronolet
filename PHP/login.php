<?php
    require __DIR__ . '\files\utility.php';
    try {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $pdo = connect();

        if(empty($_POST["user"]) || empty($_POST["pswd"]))
            throw new Exception("Dati richiesti!", 0);

        $user = $_POST["user"];
        $psw = $_POST["pswd"];

        // if(isset($_POST["keep"])){
        //     // remember me for 1 week
        //     $exp = time() + 7*(60*60*24);
        //     $path = "localhost/Progetto/";
        //     setcookie("username", $user, $exp, $path);
        // }
        
        $sql = "SELECT `password` FROM utente WHERE username = \"". $user ."\"";
        $record = $pdo->query($sql);
        $res = $record->fetch();
        if(!$res){
            throw new Exception("User not found!", 1);
        }
        
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