<?php

namespace tmukherjee13\storage;

use Gaufrette\Filesystem;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\log\Logger;

abstract class Storage extends Component
{

    protected $filesystem;

    /**
     * @var integer the chmod permission for directories and files,
     * created in the process. Defaults to 0755 (owner rwx, group rx and others rx).
     */
    public $filePermission = 0755;
    /**
     * @var string file system path, which is basic for all buckets.
     */
    public $path   = null;
    public $create = true;
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
        if ($this->path === null) {
            throw new InvalidConfigException('The "path" property must be set.');
        }
        $this->path = Yii::getAlias($this->path);

        $this->create = Yii::getAlias($this->create);

        $adapter = $this->prepareAdapter();

        $this->filesystem = new Filesystem($adapter);
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
