<?php


namespace app\Core;


use Zend\Diactoros\Response;

class View
{
    public function render($viewFile, array $args = array())
    {
        $response = new Response();

        ob_start();
        if(!empty($args)){
            extract($args);
        }
        require $_SERVER['DOCUMENT_ROOT'].'/app/Views/'.$viewFile.'.php';
        $response->getBody()->write(ob_get_clean());

        return $response->withStatus(200);
    }

    public function raw($str,$status = 200)
    {
        $response = new Response();
        $response->getBody()->write($str);
        return $response->withStatus($status);
    }

    public function json(array $array, $status = 200)
    {
        $response = new Response();
        $response->getBody()->write(json_encode($array));
        return $response->withAddedHeader('content-type', 'application/json')->withStatus($status);
    }
}