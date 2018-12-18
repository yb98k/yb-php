<?php

defined('YB_DEBUG') or define('YB_DEBUG', false);
defined('YB_ENV') or define('YB_ENV', 'dev');

// autoload 自动载入
require( __DIR__. '/../vendor/autoload.php' );

//framework start 启动框架
$config = array_merge(
    require( __DIR__ . '/../config/routes/site.php' )
);

(new \Core\Application($config))->run();