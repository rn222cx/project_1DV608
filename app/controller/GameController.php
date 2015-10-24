<?php
require_once '../app/dal/Game.php';

class GameController extends Controller
{

    private $view;

    public function __construct()
    {
        $this->view = $this->view('view', 'Game');
    }

    public function index()
    {
        return $this->view->showGame();
    }
}