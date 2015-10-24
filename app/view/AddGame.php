<?php

namespace view;

use model\IListener;

class AddGame implements IListener
{

    private static $messageId = 'view\AddGame::Message';
    private static $title = 'view\AddGame::Title';
    private static $gameFile = 'view\AddGame::GameFile';
    private static $addGame = 'view\AddGame::Game';

    private static $sessionSaveMessage = 'view\AddGame::SessionSaveMessage';

    private $message;

    public function render()
    {
        return '
			<form method="post" enctype="multipart/form-data">
				<fieldset>
					<legend>Add Game</legend>
					<p id="' . self::$messageId . '">' . $this->message . '</p>

					<label for="' . self::$title . '">Title :</label>
					<input type="text" id="' . self::$title . '" name="' . self::$title . '" value="' . $this->getTitle() . '" />
					<br>


                    <br>
                    <input type="file" id="' . self::$gameFile . '" name="' . self::$gameFile . '"/> (swf/unity)</td>
                    <br>
					<input type="submit" name="' . self::$addGame . '" value="Submit Game" />
				</fieldset>
			</form>
		';
    }

    public function addingGame()
    {


        try{
            $gameTitle = $this->getTitle();
            $gameFile = $this->getFileName();

            if(!empty($this->message))
                throw new \Exception();

            return new \model\Game(
                $gameTitle,
                $gameFile
            );
        } catch(\FileSizeException $e){
            $this->message .= "Game file is to large";
        } catch(\FileExtensionException $e){
            $this->message .= "This game type is not excepted";
        } catch(\Exception $e){
            $this->message .= "Something wrong happen";
        }

    }

    public function getTitle()
    {
        if(isset($_POST[self::$title])){
            if (strlen($_POST[self::$title]) < 3)
                $this->message .= 'Game title has too bee at least 3 characters.<br>';

            if (filter_var($_POST[self::$title], FILTER_SANITIZE_STRING) !== $_POST[self::$title]) {
                $this->message .= 'Game title contains invalid characters.<br>';
                $_POST[self::$title] = strip_tags($_POST[self::$title]);
            }

            return trim($_POST[self::$title]);
        }
    }

    public function getFileName()
    {
        if(!empty($_FILES[self::$gameFile]["name"])){
            if ($_FILES[self::$gameFile]["size"] > 20000000) // File cant be greater than 20 mb
                throw new \FileSizeException();

            return $_FILES[self::$gameFile];
        }
        else{
            $this->message .= 'Game file needs to bee included<br>';
        }
    }

    public function submitClicked()
    {
        return isset($_POST[self::$addGame]);
    }

    public function notLoggedIn()
    {
        return 'Please login to add games';
    }

    public function addGameSuccess()
    {
        $this->redirect('Game successfully added');
    }

    public function getSessionMessage() {
        if (isset($_SESSION[self::$sessionSaveMessage])) {
            $this->message = $_SESSION[self::$sessionSaveMessage];
            unset($_SESSION[self::$sessionSaveMessage]);
        }
        return;
    }

    public function redirect($message)
    {
        $_SESSION[self::$sessionSaveMessage] = $message;
        header('Location: '.$_SERVER['REQUEST_URI']);
    }

    public function errorListener($listener)
    {
        $this->message = "sorry we couldn't add your game";
    }

}