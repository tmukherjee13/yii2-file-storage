<?php
namespace tmukherjee13\storage;

use Gaufrette\Adapter\Local as LocalAdapter;

/**
 *
 */
class LocalStorage extends Storage
{

    /**
     * @inheritdoc
     */
    public function init()
    {
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
