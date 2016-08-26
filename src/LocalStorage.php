<?php
namespace tmukherjee13\storage;

use Gaufrette\Adapter\Local as LocalAdapter;
use Gaufrette\Filesystem;

/**
 *
 */
class LocalStorage extends Storage
{

    public function init($config)
    {
        # code...
        $adapter    = new LocalAdapter('storage/media');
        $filesystem = new Filesystem($adapter);

        // var_dump($filesystem->read('myFile')); // bool(false)
        $filesystem->write('myFile', 'Hello world!');

        $file = $filesystem->get('myFile');
        echo sprintf('%s (modified %s): %s', $file->getKey(), date('d/m/Y, H:i:s', $file->getMtime()), $file->getContent());
    }

}
