<?php
/**
 * Created by Yuankui
 * Date: 2018/12/18
 * Time: 16:06
 */

namespace Yb;


use Yb\routes\ybRoute;

class Application
{

    public $config;

    public $reqRoute;

    public function __construct($config)
    {

        $this->config = $config;

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
        //注册Eloquent ORM
        $capsule = new \Illuminate\Database\Capsule\Manager();
        $capsule->addConnection($this->config['dbs'] ?? []);
        $capsule->bootEloquent();

        //开始执行方法
        try {
            $this->execute();
        } catch (\Exception $e) {
            if(YB_DEBUG) {
                throw new \Exception($e->getMessage());
            }
        }
    }

    /**
     * @throws \Exception
     */
    public function execute()
    {
        //获取类路径和方法
        $finalPos = strrpos($this->reqRoute, '/');
        $method   = mb_substr($this->reqRoute, $finalPos+1);
        $class    = mb_substr($this->reqRoute, 0, $finalPos);
        //获取具体类
        $finalPos = strrpos($class, '/');
        $path     = mb_substr($class, 0, $finalPos);
        $reqClass = mb_substr($class, $finalPos);

        //请求具体类
        $reqPathClass = '\\App\\controllers\\' . trim(str_replace('/', '\\', $path . '/' . ucfirst($reqClass) . 'Controller'), '\\');
        $class        = new $reqPathClass();

        if(method_exists($class, $method)) {
            call_user_func([$class, $method]);
        } else {
            if(YB_DEBUG) {
                throw new \Exception('not this method');
            }
        }
    }
}