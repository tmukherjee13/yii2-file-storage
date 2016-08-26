<?php
namespace tmukherjee13\storage;

use Gaufrette\Adapter\Local as LocalAdapter;
use Gaufrette\Filesystem;

/**
 *
 */
class LocalStorage extends Storage
{

    public function initi($config)
    {
        # code...
        $adapter    = new LocalAdapter('storage/media');
        $filesystem = new Filesystem($adapter);

        // var_dump($filesystem->read('myFile')); // bool(false)
        $filesystem->write('myFile', 'Hello world!');

        $file = $filesystem->get('myFile');
        echo sprintf('%s (modified %s): %s', $file->getKey(), date('d/m/Y, H:i:s', $file->getMtime()), $file->getContent());
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->path === null) {
            throw new InvalidConfigException('The "path" property must be set.');
        }
        $this->path = Yii::getAlias($this->path);
        parent::init();
    }
    /**
     * @return LocalAdapter
     */
    protected function prepareAdapter()
    {
        $config = ['key' => $this->key, 'secret' => $this->secret];

        if ($this->region !== null) {
            $config['region'] = $this->region;
        }

        if ($this->baseUrl !== null) {
            $config['base_url'] = $this->baseUrl;
        }

        return new LocalAdapter('storage/media');
    }

}
