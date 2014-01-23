 
<?php
session_start();


class Auth{

    public function logIn() {
        if (!isset($_SESSION['username'])) {
            if (!isset($_SESSION['login'])) {
                $_SESSION['login'] = TRUE;
                header('WWW-Authenticate: Basic realm="My Realm"');
                header('HTTP/1.0 401 Unauthorized');
                echo 'You must enter a valid login and password';
                echo '<p><a href="?action=logOut">Try again</a></p>';
                exit;
            } else {
                $user = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '';
                $password = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';
                $result = $this->authenticate($user, $password);
                if ($result == 0) {
                    $_SESSION['username'] = $user;
                } else {
                    session_unset($_SESSION['login']);
                    $this->errMes($result);
                    echo '<p><a href="">Try again</a></p>';
                    exit;
                };
            };
        }
    }

    public function authenticate($user, $password) {
        
        if (($user == UserAuth)&&($password == PasswordAuth)){ 
            return 0;
        }else{
            return 1;
        }
    }

    public function errMes($errno) {
        switch ($errno) {
            case 0:
                break;
            case 1:
                echo 'The username or password you entered is incorrect';
                break;
            default:
                echo 'Unknown error';
        };
    }

    public  function logOut() {
        session_destroy();
        if (isset($_SESSION['username'])) {
            session_unset($_SESSION['username']);
            echo "You've successfully logged out<br>";
        } else {
            header("Location: ?action=logIn", TRUE, 301);
        };
        if (isset($_SESSION['login'])) { session_unset($_SESSION['login']); };
        exit;
    }
}
