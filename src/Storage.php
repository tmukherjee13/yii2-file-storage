<?php

namespace tmukherjee13\storage;

use Gaufrette\Filesystem;
use Yii;
use yii\base\Component;
use yii\log\Logger;

abstract class Storage extends Component
{

    protected $filesystem;

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
