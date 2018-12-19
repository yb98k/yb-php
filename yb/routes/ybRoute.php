<?php
/**
 * Created by Yuankui
 * Date: 2018/12/18
 * Time: 16:40
 */

namespace Yb\routes;


use Yb\Application;

class ybRoute
{
    public $uri;

    public $routeConfig;

    public $reqUri;

    public function __construct($uri, $routeConfig)
    {
        $this->uri = $uri;
        $this->routeConfig = $this->initRouteConfig($routeConfig);
    }

    public function format(Application &$app)
    {
        $this->getNowReq();

        //处理参数
        if($this->uri) {
            $params = trim(str_replace($this->reqUri, '', $this->uri), '/');
            $urlPos = strpos($params, '?');
            $params = $urlPos !== false ? mb_substr($params, 0, $urlPos) : $params;
            $params = explode('/', $params);

            //初始化请求目标
            $app->reqRoute = mb_substr($this->uri, 0, strpos($this->uri, '?'));
        }

        if(isset($this->routeConfig[$this->reqUri]) && $this->uri) {
            //处理路由参数规则
            $paramRelation = $this->getParamRelation($this->routeConfig[$this->reqUri]['posRule']);

            //初始化请求目标
            $app->reqRoute = $this->routeConfig[$this->reqUri]['aimUrl'];

            //初始化请求参数
            $paramCount = count($paramRelation);
            for ($index = 0; $index < $paramCount; $index++) {
                if(\Yb::$entity->request->isGet) {
                    if(!isset($_GET[$paramRelation[$index]]))
                        $_GET[$paramRelation[$index]] = $params[$index] ?? NULL;
                }
                if(\Yb::$entity->request->isPost) {
                    if(!isset($_POST[$paramRelation[$index]]))
                        $_POST[$paramRelation[$index]] = $params[$index] ?? NULL;
                }
                if(!isset($_REQUEST[$paramRelation[$index]]))
                    $_REQUEST[$paramRelation[$index]] = $params[$index] ?? NULL;
            }
        }
    }

    public function initRouteConfig($routeConfig)
    {
        $returnConfig = [];

        foreach ($routeConfig as $rule => $aimUrl) {
            $pos = strpos($rule, '/{');
            $key = $pos !== false ? mb_substr($rule, 0, $pos) : $rule;

            $returnConfig[$key] = [
                'aimUrl'  => $aimUrl,
                'posRule' => trim(mb_substr($rule, $pos), '/')
            ];
        }

        return $returnConfig;
    }

    public function getParamRelation($posRule)
    {
        $posRule = str_replace('{', '', $posRule);
        $posRule = str_replace('}', '', $posRule);
        $ruleArr = explode('/', $posRule);

        return $ruleArr;
    }

    public function getNowReq()
    {
        $allRuleKey = array_keys($this->routeConfig);
        $reqArr = explode('/', $this->uri);

        $req = '';
        foreach ($reqArr as $key) {
            $req = trim($req.'/'.$key, '/');
            if(in_array($req, $allRuleKey)) {
                $this->reqUri = $req;
                break;
            }
        }
    }
}