<?php


namespace app\Core;


class Contoller
{
    /**
     * @var View
     */
    protected $view;

    public function __construct()
    {
        $this->view  = new View();
    }

    protected function redirect($relativePath)
    {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/$relativePath";

        return $this->view->render('redirect', ['url' => $url]);
    }
}