<?php

namespace model;

class Game
{
    private $title;
    private $gameFile;
    private $image;
    private $fileExtension;
    private $gameID;

    private $validFileTypes = array(
        'swf',
        'unity3d'
    );

    private $validImgTypes = array(
        'jpg',
        'jpeg',
        'png',
        'gif'
    );


    /**
     * @param $title
     * @param $gameFile
     * @param null $id
     * @throws \FileExtensionException
     */
    public function __construct($title, $gameFile, $image, $id = null)
    {
        /**
         * If game file comes from add new game it is an array.
         */
        if(is_array($gameFile)){
            $fileExt = strtolower(pathinfo($gameFile['name'], PATHINFO_EXTENSION));
            $imgExt = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        }
        else{
            $fileExt = strtolower(pathinfo($gameFile, PATHINFO_EXTENSION));
            $imgExt = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        }

        /**
         * Check if filename has a valid file extension from array
         */
        if (!in_array($fileExt, $this->validFileTypes) || !in_array($imgExt, $this->validImgTypes))
            throw new \FileExtensionException();


        $this->title = trim($title);
        $this->gameFile = $gameFile;
        $this->image = $image;
        $this->fileExtension = $fileExt;
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

    public function getImage()
    {
        return $this->image;
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