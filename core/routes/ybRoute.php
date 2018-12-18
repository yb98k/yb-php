<?php
/**
 * Created by Yuankui
 * Date: 2018/12/18
 * Time: 16:40
 */

namespace Core\routes;


use Core\Application;

class ybRoute
{
    public $uri;

    public $routeConfig;

    public function __construct($uri, $routeConfig)
    {
        $this->uri = $uri;
        $this->routeConfig = $routeConfig;
    }

    public function format(Application &$app)
    {
        $app->reqRoute = 'test';
    }
}