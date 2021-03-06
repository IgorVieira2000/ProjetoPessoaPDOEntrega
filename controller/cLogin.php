<?php
/**
 * Description of cLogin
 *
 * @author Igor
 */
class cLogin {
    public function login() {
        if (isset($_POST['logar'])) {
            $email = $_POST['email'];
            $pas = $_POST['pas'];
            

            $pdo = require '../pdo/connection.php';
            $sql = "select * from usuario where email =?";
            $sth = $pdo->prepare($sql);
            $sth->execute([$email]);
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $count = $sth->rowCount();
            if ($count > 0) {
                if (password_verify($pas, $result['pas'])) {
                    session_start();
                    $_SESSION['usuarioT'] = $result['nome'];
                    $_SESSION['emailT'] = $result['email'];
                    $_SESSION['logadoT'] = true;
                    header("Location: ../index.php");
                }
            } else {
                header('Location: login.php');
            }
            
            unset($sth);
            unset($pdo);
        }
    }
}