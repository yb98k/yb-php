<?php
/**
 * Created by Yuankui
 * Date: 2018/12/18
 * Time: 16:06
 */

namespace Core;


use Core\routes\ybRoute;

class Application
{

    public $reqRoute;

    public $routeConfig;

    public function __construct($config)
    {

        $this->reqRoute = trim($_SERVER['REQUEST_URI'], '/');

        if(!$this->reqRoute) {
            $this->reqRoute = $config['defaultRoute'] ?? 'home/index';
        }
        if(!empty($config['routes'])) {
            $ybRoute = new ybRoute($this->reqRoute, $config['routes']);
            $ybRoute->format($this);
        }
    }

    public function run()
    {

        //开始执行方法
        $this->execute();
    }

    public function execute()
    {
        var_dump($this->reqRoute,$_GET);die;
    }
}