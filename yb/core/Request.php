<?php
/**
 * Created by Yuankui
 * Date: 2018/12/19
 * Time: 15:12
 */

namespace Yb\core;


class Request
{
    public $isGet = false;

    public $isPost = false;

    public $isHead = false;

    public $isPut = false;

    public $queryString = '';

    public function __construct()
    {
        $this->getRequestMethod();
    }

    public function getQueryString()
    {
        return $this->queryString;
    }

    public function getRequestMethod()
    {
        $method = strtolower($_SERVER['REQUEST_METHOD'] ?? '');

        switch ($method) {
            case 'get'  : $this->isGet  = true;break;
            case 'post' : $this->isPost = true;break;
            case 'head' : $this->isHead = true;break;
            case 'put'  : $this->isPut = true;break;

            default:break;
        }
    }
}