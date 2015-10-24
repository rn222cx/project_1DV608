<?php

namespace dal;

use model\GameList;

class Game
{

    private $db;
    private $gameList;

    public function __construct() {
        $this->db = new \Db();
    }

    public function add(\model\Game $credential, \model\IListener $listener)
    {
        try {
            $random = rand(0, pow(10, 5)) . '-'; // 5 digit random number to prefix game name
            $gameDirectory = "../public/games/"; // path to game directory

            $fileExtension = $credential->getFileExtension();
            $title = $credential->getTitle();
            $gameFile = $random . $credential->getGameFile()["name"];
            $target_file = $gameDirectory . $gameFile;

            move_uploaded_file($credential->getGameFile()["tmp_name"], $target_file);

            $records = $this->db;

            $records->query('INSERT INTO game (title, game, gameType) VALUES (:title, :game, :gameType)');
            $records->bind(':title', $title);
            $records->bind(':game', $gameFile);
            $records->bind(':gameType', $fileExtension);
            $records->execute();

            return true;

        } catch (\Exception $e) {
            $listener->errorListener("AddGameDal::CouldNotAddGameException");
        }

    }

    public function getGames(GameList $gameList) {

        $this->gameList = $gameList;

        $this->db;

        $records = new \Db();
        $records->query('SELECT * FROM game');

        $rows = $records->resultset();

        foreach($rows as $row){
            $game = new \model\Game($row['title'], $row['game'], $row['id']);
            $this->gameList->add($game);
        }

        return  $this->gameList;
    }
}