<?php
namespace backend\components;

use Aws\Credentials\Credentials;

use yii\base\Component;
use Aws\S3\S3Client;

class AmazonS3 extends Component {

  private $s3Client;

  public $bucketName;
  public $key;
  public $secret;

  function __construct() {
    parent::__construct();

    // $provider = new Credentials([
    //   'key' => $this->key,
    //   'secret' => $this->secret
    // ]);
    
    // Instantiate the S3 client with your AWS credentials
    $this->s3Client = new S3Client([
        'version'     => 'latest',
        'region'      => 'us-west-2',
        'credentials' => false
    ]);
    
    //var_dump(get_class_methods($this->s3Client));die;
  }

  function uploadImage($pathToFile) {
    $result = $this->s3Client->putObject(array(
        'Bucket'     => $this->bucketName,
        'Key'        => $this->key,
        'SourceFile' => $pathToFile,
        'Metadata'   => array(
            'Foo' => 'abc',
            'Baz' => '123'
        )
    ));

    return $result;
  }
}
