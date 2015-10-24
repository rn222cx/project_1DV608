<?php

namespace view;


use model\SessionStorage;

class NavBar
{
    private $sessionStorage;

    public function __construct()
    {
        $this->sessionStorage = new SessionStorage();
    }
    public function navigationMenu()
    {
        if($this->isLoggedIn()){
            return
                '<div class="links">
                        <a href="/new">Home</a>
                        <a href="addgames">Add Games</a>
                        <a href="login?logout">Logout</a>
                 </div>';
        }
        else{
            return
                '<div class="links">
                        <a href="/new">Home</a>
                        <a href="addgames">Add Games</a>
                        <a href="register">Register</a>
                        <a href="login">Login</a>
                 </div>';
        }
    }

    public function isLoggedIn()
    {
        return $this->sessionStorage->exist(SessionStorage::$auth);
    }

}