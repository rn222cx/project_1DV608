<?php


class Controller
{
    protected function model($nameSpace = '', $model, $injection = '')
    {
        require_once '../app/model/'. $model .'.php';

        $class = $nameSpace.'\\'.$model;
        return new $class($injection);
    }

    protected function view($nameSpace = '', $model, $injection = '', $injection2 = '')
    {
        require_once '../app/view/'. $model .'.php';

        $class = $nameSpace.'\\'.$model;
        return new $class($injection, $injection2);
    }

    protected function dal($nameSpace = '', $model, $injection = '')
    {
        require_once '../app/dal/'. $model .'.php';

        $class = $nameSpace.'\\'.$model;
        return new $class($injection);
    }
}