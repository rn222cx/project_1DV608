<?php

namespace view;

class Login
{
    private static $login = 'view\Login::Login';
    private static $name = 'view\Login::UserName';
    private static $password = 'view\Login::Password';
    private static $messageId = 'view\Login::Message';
    private static $logoutURLID = 'logout';

    private $message;
    public $loginSuccess = null;
    private $loginModel;

    public function __construct(\model\Login $login)
    {
        $this->loginModel = $login;
    }

    public function userWantsToLogout()
    {
        return isset($_GET[self::$logoutURLID]);
    }

    public function userWantsToLogin()
    {
        return isset($_POST[self::$login]);
    }

    public function getCredentials()
    {
        try {
            return new \model\User(
                $this->getUsername(),
                $this->getPassword());
        } catch (\Exception $e) {
            $this->message = "Obs!<br>";
        }

    }

    public function getUsername(){
        if(isset($_POST[self::$name])){
            return trim($_POST[self::$name]);
        }
    }

    public function getPassword(){
        if(isset($_POST[self::$password])){
            return trim($_POST[self::$password]);
        }
    }

    public function redirectToHomePage()
    {
        $homePage = '/new';
        //$homePage = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
        header("Location: $homePage");
    }

    public function response()
    {
        if($this->userWantsToLogin()){
            if (empty($this->getUsername())) {
                $this->message .= "Username is missing<br>";
            }
            if (empty($this->getPassword())) {
                $this->message .= "Password is missing<br>";
            }
            if ($this->loginSuccess == true) {
                $this->message = "Welcome";
            }
            if ($this->loginSuccess == false) {
                $this->message .= "Wrong name or password";
            }
        }

        if ($this->loginModel->isLoggedIn()) {
            $response = $this->generateLogoutButtonHTML();
        } else {
            $response = $this->generateLoginFormHTML($this->message);
        }

        return $response;
    }

    private function generateLoginFormHTML($message)
    {
        return '
			<form method="post" >
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>

					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->getUsername() . '" />
					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
    }

    private function generateLogoutButtonHTML() {
        return '
            You are logged in <br>
            <a href="login?logout">Logout</a>
		';
    }
}