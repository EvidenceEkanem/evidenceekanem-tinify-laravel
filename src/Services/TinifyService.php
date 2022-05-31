<?php
namespace evidenceekanem\LaravelTinify\Services;

use Tinify\Source;
use Tinify\Tinify;

class TinifyService {

    /**
     * Get api key from env, fail if any are missing.
     * Instantiate API client and set api key.
     *
     * @throws Exception
     */
    public function __construct() {
        $this->apikey = config('tinify.apikey');
        if(!$this->apikey) {
            throw new \InvalidArgumentException('Please set TINIFY_API_KEY environment variables.');
        }
        $this->client = new Tinify();
        $this->client->setKey($this->apikey);

        $this->AWS_ACCESS_KEY_ID = env('AWS_ACCESS_KEY_ID');
        $this->AWS_SECRET_ACCESS_KEY = env('AWS_SECRET_ACCESS_KEY');
        $this->AWS_DEFAULT_REGION = env('AWS_DEFAULT_REGION');
    }
    public function setKey($key) {
        return $this->client->setKey($key);
    }

    public function setAppIdentifier($appIdentifier) {
        return $this->client->setAppIdentifier($appIdentifier);
    }

    public function getCompressionCount() {
        return $this->client->getCompressionCount();
    }

     public function compressionCount() {
        return $this->client->getCompressionCount();
    }

    public function fromFile($path) {
        return Source::fromFile($path);
    }

    public function fromBuffer($string) {
        return Source::fromBuffer($string);
    }

    public function fromUrl($string) {
        return Source::fromUrl($string);
    }

    function isS3Set() {
        if($this->AWS_ACCESS_KEY_ID && $this->AWS_SECRET_ACCESS_KEY && $this->AWS_DEFAULT_REGION ) {
            return true;
        }

        throw new \InvalidArgumentException('Please set S3 environment variables.');
    }

    public function fileToS3($source_path, $bucket, $destination_path) {
        if($this->isS3Set()) {
            return Source::fromFile($source_path)
                ->store(array(
                    "service" => "s3",
                    "aws_access_key_id" => $this->AWS_ACCESS_KEY_ID,
                    "aws_secret_access_key" => $this->AWS_SECRET_ACCESS_KEY,
                    "region" => $this->AWS_DEFAULT_REGION,
                    "path" => $bucket . $destination_path,
                ));
        }
    }

    public function bufferToS3($string, $bucket, $path) {
        if($this->isS3Set()) {
            return Source::fromBuffer($string)
                ->store(array(
                    "service" => "s3",
                    "aws_access_key_id" => $this->AWS_ACCESS_KEY_ID,
                    "aws_secret_access_key" => $this->AWS_SECRET_ACCESS_KEY,
                    "region" => $this->AWS_DEFAULT_REGION,
                    "path" => $bucket . $path,
                ));
        }
    }

    public function urlToS3($url, $bucket, $path) {
        if($this->isS3Set()) {
            return Source::fromUrl($url)
                ->store(array(
                    "service" => "s3",
                    "aws_access_key_id" => $this->AWS_ACCESS_KEY_ID,
                    "aws_secret_access_key" => $this->AWS_SECRET_ACCESS_KEY,
                    "region" => $this->AWS_DEFAULT_REGION,
                    "path" => $bucket . $path,
                ));
        }
    }

    public function validate() {
        try {
            $this->client->getClient()->request("post", "/shrink");
        } catch (ClientException $e) {
            return true;
        }
    }
}