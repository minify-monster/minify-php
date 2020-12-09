# minify.monster API client for PHP

PHP client for [minify.monster](https://minify.monster) services.

## Usage

**Request for Image URL:**

````php
$params = [
	'url' => 'https://site-url.com/file.jpg',
	'from_url' => true,
	'images' => [
		[
			'mode' => 'auto',
			'extension' => 'jpg',
			'width' => 1920,
			'height' => 1920
		],[
			'mode' => 'fill',
			'extension' => 'webp',
			'width' => 300,
			'height' => 300
		]
	]
]
$monster = new Monster($apikey);
$response = $monster->minify($params);
````
**Request for Image upload:**

````php
require_once 'minify.monster.php';
$params = [
	'url' => '/var/www/your-site/file.jpg',
	'images' => [
		[
			'mode' => 'auto',
			'extension' => 'jpg',
			'width' => 1920,
			'height' => 1920
		],[
			'mode' => 'fill',
			'extension' => 'webp',
			'width' => 300,
			'height' => 300
		]
	]
]
$monster = new Monster('your-api-key');
$response = $monster->minify($params);
````

**Response:**

````js
{
	'success': true,
	'images': {
		'https://storage.minify.monster/random-filename-for-file-1.jpg',
		'https://storage.minify.monster/random-filename-for-file-2.webp'
	}
}
````

### Usage
Download minified images from our storage to you. Generated images are accessible only for 1 hour. 

````js
{
	'success': false,
	'message': 'error message'
}
````

### Input parameters

- `url` - image url or location on server
- `from_url` - true if image url
- `width` - in pixels (if not set, width will preserve)
- `height` - in pixels (if not set, height will preserve)
- `images` - array with requests for compression

The `extension` property can have one of the following values:

- `jpg`
- `png`
- `webp`

The `quality` property can have one of the following values:

- `auto` - default, if not set (auto quality is really recommended)
- `X` - percentage (integer)

The `mode` property can have one of the following values:

- `auto` - default, if not set
- `fill` - background with white color
- `crop`

The `method` property can have one of the following values:

- `LANCZOS` - default, if not set
- `NEAREST`
- `BOX`
- `BILINEAR`
- `HAMMING`
- `BICUBIC`
