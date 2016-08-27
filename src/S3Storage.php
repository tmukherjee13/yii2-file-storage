<?php
namespace tmukherjee13\storage;

use Aws\S3\S3Client;
use Gaufrette\Adapter\AwsS3 as AwsS3Adapter;
use Gaufrette\Adapter\Local as LocalAdapter;
use Yii;

/**
 *
 */
class S3Storage extends Storage
{

    public $bucket;
    public $key;
    public $secret;
    public $region;
    public $version = 'latest';

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->bucket === null) {
            throw new InvalidConfigException('The "bucket" property must be set.');
        }
        $this->bucket = Yii::getAlias($this->bucket);

        if ($this->key === null) {
            throw new InvalidConfigException('The "key" property must be set.');
        }
        $this->key = Yii::getAlias($this->key);

        if ($this->secret === null) {
            throw new InvalidConfigException('The "secret" property must be set.');
        }
        $this->secret = Yii::getAlias($this->secret);

        if ($this->region === null) {
            throw new InvalidConfigException('The "region" property must be set.');
        }
        $this->region = Yii::getAlias($this->region);

        parent::init();
    }
    /**
     * @return LocalAdapter
     */
    protected function prepareAdapter()
    {

        $s3client = S3Client::factory(array(
            // 'profile' => 'default',
            'key'     => $this->key,
            'secret'  => $this->secret,
            'version' => $this->version,
            'region'  => $this->region,
        ));
        return new AwsS3Adapter($s3client, $this->bucket);
    }

}
