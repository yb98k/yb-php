<?php
/**
 * Created by Yuankui
 * Date: 2018/12/19
 * Time: 14:03
 */

class Yb
{
    /**
     * @var \Yb\Entity
     */
    public static $entity = null;

    private static $_instance = null;

    private static $classMap = [];

    private function __construct() {}

    private function __clone() {}

    public static function getInstance()
    {
        if(!self::$_instance instanceof self) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public static function setClassMap($classMap)
    {
        self::$classMap = $classMap;
    }

    public static function autoload($className)
    {
        $className = trim($className, '/');
        if(isset(static::$classMap[$className])) {
            $classFile = static::$classMap[$className];
        } elseif(strpos($className, '\\') !== false) {
            $classFile = YB_PATH. 'app/controllers/' . str_replace('\\', '/', $className) . '.php';
        } else {
            return;
        }

        include($classFile);

        if (YB_DEBUG && !class_exists($className, false)
            && !interface_exists($className, false) && !trait_exists($className, false)) {
            throw new \Exception(
                "Unable to find '$className' in file: $classFile. Namespace missing?");
        }
    }
}

spl_autoload_register([Yb::class, 'autoload'], true, true);

Yb::setClassMap(require ( __DIR__.'/classMap.php' ));

Yb::$entity = new \Yb\Entity();