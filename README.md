# evidenceekanem/tinify-laravel
Tinify API support with laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/evidenceekanem/tinify-laravel?label=version)](https://packagist.org/packages/evidenceekanem/tinify-laravel)
[![Total Downloads](http://poser.pugx.org/evidenceekanem/tinify-laravel/downloads)](https://packagist.org/packages/evidenceekanem/tinify-laravel)
[![License](http://poser.pugx.org/evidenceekanem/tinify-laravel/license)](https://packagist.org/packages/evidenceekanem/tinify-laravel)
## Install

``` bash
$ composer require evidenceekanem/tinify-laravel
```

Add this to your config/app.php, 

under "providers":
```php
    evidenceekanem\LaravelTinify\LaravelTinifyServiceProvider::class,
```
under "aliases":

```php
    'Tinify' => evidenceekanem\LaravelTinify\Facades\Tinify::class
```


And set a env variable `TINIFY_API_KEY` with your tinypng api key.

If you want to directly upload the image to `aws s3`, you need set the env variables of following with your aws s3 credentials.

```php
    AWS_ACCESS_KEY_ID=
    AWS_SECRET_ACCESS_KEY=
    AWS_DEFAULT_REGION=
    AWS_BUCKET=
```

## Examples

```php
	$result = Tinify::fromFile('\path\to\file');


	$result = Tinify::fromBuffer($source_data);

	$result = Tinify::fromUrl($image_url);

	/** To save as File **/
	$result->toFile('\path\to\save');

	/** To get image as data **/
	$data = $result->toBuffer();
```

```php

	$s3_result = Tinify::fileToS3('\path\to\file', $AWS_BUCKET_name, '/path/to/save/in/bucket');

	$s3_result = Tinify::bufferToS3($source_data, $AWS_BUCKET_name, '/path/to/save/in/bucket');

	$s3_result = Tinify::urlToS3($image_url, $AWS_BUCKET_name, '/path/to/save/in/bucket');

	/** To get the url of saved image **/
	$s3_image_url = $s3_result->location();
	$s3_image_width = $s3_result->width();
	$s3_image_hight = $s3_result->height();

```

`NOTE:` All the images directly save to s3 is publicably readable. And you can set permissions for s3 bucket folder in your aws console to make sure the privacy of images.
