<?php

namespace view;

use model\GameList;

class Home
{
    private $gameList;
    private $navigation;

    public function __construct(GameList $gameList, Navigation $navigation)
    {
        $this->gameList = $gameList;
        $this->navigation = $navigation;
    }
    public function render()
    {
        $gameList = $this->gameList->getGames();

        $ret = "<ul>";

        foreach ($gameList as $game) {

            $title = $game->getTitle();
            $urlID = $game->getGameID();
            $url = $this->navigation->getGameURL($urlID);

            $ret .= "<li><a href='".$url."/".$title."'>$title</a></li>";
        }
        $ret .= "</ul>";

        return "<h2>List of games</h2> $ret";

    }

    public function getSelectedGame() {
        assert($this->navigation->gameIsSelected());
        $unique = $this->navigation->getGameID();

        $game = $this->gameList->getGameByID($unique);

        if ($game != null)
            return $game;

        throw new \Exception("unknown game id");

    }


}