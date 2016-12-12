<?php
namespace tmukherjee13\storage;

use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\helpers\FileHelper;

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
        if (self::$_storage) {
            return self::$_storage;
        }

        foreach ($app->components as $name => $config) {
            $class = is_string($config) ? $config : @$config['class'];
            if ($class == str_replace('Bootstrap', 'Manager', get_called_class())) {
                return self::$_storage = $app->$name;
            }
        }

        $configFilename = \Yii::getAlias('@app/config/_storage.php');
        if (!file_exists($configFilename)) {
            FileHelper::copyDirectory(\Yii::getAlias('@vendor/tmukherjee13/yii2-storage/src/config'), \Yii::getAlias('@app/config/'), []);
        }

        $eventFile = \Yii::getAlias('@app/config/_storage.php');
        \Yii::configure(\Yii::$app, require ($configFilename));

        return self::$_storage = $app->storage;
    }
}
