<?php

defined('YB_DEBUG') or define('YB_DEBUG', false);
defined('YB_ENV') or define('YB_ENV', 'dev');

defined('YB_PATH') or define('YB_PATH', __DIR__ . '/../');


// autoload 自动载入
require( __DIR__. '/../vendor/autoload.php' );
require(__DIR__ . '/../yb/Yb.php');

//framework start 启动框架
$config = array_merge(
    require( __DIR__ . '/../config/routes/site.php' ),
    require( __DIR__ . '/../config/main.php' )
);

try {
    (new \Yb\Application($config))->run();
} catch (Exception $e) {
    throw new \Exception($e->getMessage());
}