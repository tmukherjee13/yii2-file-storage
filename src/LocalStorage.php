<?php
namespace tmukherjee13\storage;

use Gaufrette\Adapter\Local as LocalAdapter;

/**
 *
 */
class LocalStorage extends Storage
{
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
     * @inheritdoc
     */
    public function init()
    {
        if ($this->path === null) {
            throw new InvalidConfigException('The "path" property must be set.');
        }
        $this->path = Yii::getAlias($this->path);

        $this->create = Yii::getAlias($this->create);
        
        parent::init();
    }
    /**
     * @return LocalAdapter
     */
    protected function prepareAdapter()
    {

        return new LocalAdapter($this->path, $this->create);
    }

}
