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
$monster = new Monster('your-api-key');
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
	'images': [
		'https://storage.minify.monster/random-filename-for-file-1.jpg',
		'https://storage.minify.monster/random-filename-for-file-2.webp'
	]
}
````

Download minified images from our storage to you. Generated images are accessible only for 1 hour. 

````js
{
	'success': false,
	'message': 'error message'
}
````

### Input parameters

- `url` - image url or location on server
	- *required*
- `from_url` - true if image url
	- *required if `url`*
- `images` - array with requests for compression
	- *required*

#### images request:

- `width` - in pixels
	- if not set, width will preserve
- `height` - in pixels
	- if not set, height will preserve
- `extension` - set ouput format
	- if not set, same extension as source will be used
- `quality` - set quality compression
- `mode` - resized strategy
- `method` - used optimize method
- `background` - set the background color, if necessary
	- for fill mode, or for png transparent images optimized to non-transparent format
	- can be formatted in HEX #fff or #ffffff, rgb(255, 255, 255) or rgba(255, 255, 255, 0))
	- default white
- `lossless` - set lossless compression
	- used for **webp** output only
	- set losslees to true if you want best quality and size doesn't matter (parameter quality is ignored)

The `extension` property can have one of the following values:

- `jpg`
- `png`
- `webp`

The `quality` property can have one of the following values:

- `auto` - default, if not set
	- auto quality is **highly recommended**
- `X` - quality in percentage (integer)

The `mode` property can have one of the following values:

- `auto` - default, if not set
- `fill`
- `crop`
- `exact` - if width or height not set (or 0), then aspect ratio is used

The `method` property can have one of the following values:

- `LANCZOS` - default (and best), if not set
- `NEAREST`
- `BOX`
- `BILINEAR`
- `HAMMING`
- `BICUBIC`

The `background` property examples:

- `#fff`
- `#ffffff`
- `rgb(255, 255, 255)`
- `rgba(255, 255, 255, 0)`

The `lossless` property examples:

- `true`
