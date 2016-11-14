Yii2 File Storage
=================
File system Abstraction Layer for Yii2

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist tmukherjee13/yii2-storage "*"
```

or add

```
"tmukherjee13/yii2-storage": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Create a file '_storage.php' inside the config directory of your application with the following contents: 

```
<?php
    return [
        'components' => [
           'storage' => [
                'class'  => 'tmukherjee13\storage\S3Storage',
                'bucket' => '<your-s3-bucket-name>',
                'key'    => '<s3-access-key>',
                'secret' => '<s3-secret-key>',
                'region' => '<s3-bucket-region>',
            ]
        ]
    ];
```

To use your local filesystem as storage use:
```
<?php
    return [
        'components' => [
            'storage' => [
                'class'  => 'tmukherjee13\storage\LocalStorage',
                'path'   => 'uploads', //base directory for storage
                'create' => true,
            ]
        ]
    ];
```

To write data:

```
$storage = Yii::$app->storage;
$storage->write('dir/file.txt', 'Hello World!',true); // params are: file, content , overwrite
```

To read data:

```
$file = $storage->get('dir/file.txt');
echo $file->getContent();
```
