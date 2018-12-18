<?php
/**
 * Created by Yuankui
 * Date: 2018/12/18
 * Time: 16:33
 */

if(YB_ENV !== 'prod') {
    $db = require( __DIR__ . '/dbs/dbConfig.php' );
} else {
    $db = require( __DIR__ . '/dbs/dbConfig-dev.php' );
}

return [
    'defaultRoute' => 'home/index',
    'dbs'          => $db,
    'urlFormat'    => 1,
];