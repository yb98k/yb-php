<?php
/**
 * Created by Yuankui
 * Date: 2018/12/19
 * Time: 15:09
 */

namespace Yb;

use Yb\core\Request;

class Entity
{
    /**
     * @var Request
     */
    public $request;

    public function __construct()
    {
        $this->request = new Request();
    }
}