<?php
return [
    'components' => [
        'storage' => [
            'class'  => 'tmukherjee13\storage\LocalStorage',
            'path'   => 'media',
            'create' => true,
        ],
        /*
            Or you can use the following configuration to store your contents in S3
         
        'storage' => [
            'class'  => 'tmukherjee13\storage\S3Storage',
            'bucket' => 'my-s3-bucket',
            'key'    => 's3-access-key',
            'secret' => 's3-secret-key',
            'region' => 'bucket-region',
        ]
        */
    ]
];
