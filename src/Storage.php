<?php

namespace tmukherjee\storage;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\caching\Cache;
use yii\log\Logger;

abstract class Storage extends Component implements StorageInterface
{

    public $config;
    public $cache;
    public $cacheKey      = 'filestorage';
    public $cacheDuration = 3600;
    public $replica;
    protected $filesystem;

    /**
     * @var integer the chmod permission for directories and files,
     * created in the process. Defaults to 0755 (owner rwx, group rx and others rx).
     */
    public $filePermission = 0755;
    /**
     * @var string file system path, which is basic for all buckets.
     */
    private $_basePath = '';
    /**
     * @var string web URL, which is basic for all buckets.
     */
    private $_baseUrl = '';

    /**
     * Logs a message.
     * @see Logger
     * @param string $message message to be logged.
     * @param integer $level the level of the message.
     */
    protected function log($message, $level = Logger::LEVEL_INFO)
    {
        if (!YII_DEBUG && $level === Logger::LEVEL_INFO) {
            return;
        }
        $category = get_class($this);
        Yii::getLogger()->log($message, $level, $category);
    }

    public function init()
    {
        $adapter = $this->prepareAdapter();

        if ($this->cache !== null) {
            /* @var Cache $cache */
            $cache = Yii::$app->get($this->cache);

            if (!$cache instanceof Cache) {
                throw new InvalidConfigException('The "cache" property must be an instance of \yii\caching\Cache subclasses.');
            }

            $adapter = new CachedAdapter($adapter, new YiiCache($cache, $this->cacheKey, $this->cacheDuration));
        }

        if ($this->replica !== null) {
            /* @var Filesystem $filesystem */
            $filesystem = Yii::$app->get($this->replica);

            if (!$filesystem instanceof Filesystem) {
                throw new InvalidConfigException('The "replica" property must be an instance of \creocoder\flysystem\Filesystem subclasses.');
            }

            $adapter = new ReplicateAdapter($adapter, $filesystem->getAdapter());
        }

        $this->filesystem = new NativeFilesystem($adapter, $this->config);
    }

    /**
     * @return AdapterInterface
     */
    abstract protected function prepareAdapter();

    /**
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->filesystem, $method], $parameters);
    }
}
