<?php


namespace app\Helpers;


class UrlHelper
{
    /**
     * @param $url
     * @param array $param
     * @return string
     */
    public static function getLink($url, array $param)
    {
        $fullParams = array_merge($_GET, $param);

        return $url.'?'.http_build_query($fullParams);
    }
}