<?php

namespace model;

class Game
{
    private $title;
    private $gameFile;
    private $fileExtension;
    private $gameID;

    private $file_types = array(
        'swf',
        'unity3d'
    );


    /**
     * @param $title
     * @param $gameFile
     * @param null $id
     * @throws \FileExtensionException
     */
    public function __construct($title, $gameFile, $id = null)
    {
        /**
         * If game file comes from add new game it is an array.
         */
        if(is_array($gameFile))
            $file_ext = strtolower(pathinfo($gameFile['name'], PATHINFO_EXTENSION));
        else
            $file_ext = strtolower(pathinfo($gameFile, PATHINFO_EXTENSION));

        /**
         * Check if filename has a valid file extension from array
         */
        if (!in_array($file_ext, $this->file_types))
            throw new \FileExtensionException();


        $this->title = trim($title);
        $this->gameFile = $gameFile;
        $this->fileExtension = $file_ext;
        $this->gameID = $id;

    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getGameFile()
    {
        return $this->gameFile;
    }

    public function getFileExtension()
    {
        return $this->fileExtension;
    }

    public function getGameID()
    {
        return $this->gameID;
    }

}