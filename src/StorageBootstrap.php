<?php
namespace tmukherjee13\storage;

use yii\base\BootstrapInterface;
use yii\base\Application;

class StorageBootstrap implements BootstrapInterface
{
    /**
     * @var EventHandler EventHandler memory storage for getEventHandler method
     */
    protected static $_storage;
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {

        die(__FILE__);
        self::getStorage($app);
    }
    /**
     * finds and creates app event manager from its settings
     * @param Application $app yii app
     * @return EventManager app event manager component
     * @throws Exception Define event manager
     */
    public static function getStorage($app)
    {
        // if (self::$_storage) {
        //     return self::$_storage;
        // }

        // foreach ($app->components as $name => $config) {
        //     $class = is_string($config) ? $config : @$config['class'];
        //     if($class == str_replace('Bootstrap', 'Manager', get_called_class())){
        //         return self::$_eventHandler = $app->$name;
        //     }
        // }

        $eventFile = \Yii::getAlias('@app/config/_storage.php');

        die($eventFile);

        \Yii::configure($this, require(\Yii::getAlias('@app/config/_storage.php')));

        // $app->setComponents([
        //     'storage' => [
        //         'class'  => 'tmukherjee13\storage\EventHandler',
        //         'events' => file_exists($eventFile) && is_file($eventFile)
        //             ? include $eventFile 
        //             : []
        //     ],
        // ]);
        return self::$_storage = $app->_storage;
    }
}