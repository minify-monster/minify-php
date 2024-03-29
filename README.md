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
	],
	'extra': [
		'white': 80
	]
}
````

Download minified files from our storage to you. Generated images are accessible only for few hours. 

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
- `mode` - resizing strategy
- `method` - resizing method
- `background` - set the background color, if necessary
	- for fill mode, or for png transparent images optimized to non-transparent format
	- can be formatted in HEX #fff or #ffffff, rgb(255, 255, 255) or rgba(255, 255, 255, 0))
	- default white
- `lossless` - set lossless compression
	- used for **webp** output only
	- set losslees to true if you want best quality and size doesn't matter (parameter quality is ignored)
- `watermark` - url of watermark image
	- if you want to add watermark into output image
- `watermark_position` - watermark position
- `watermark_size` - in percent

The `extension` property can have one of the following values:

- `jpg`
- `png`
- `webp`
- `gif`
- `svg` - only if source is svg too
- `css` - only if source is css too (no need to enter, css will output always as css)
- `js` - only if source is js too (no need to enter, js will output always as js)

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

- `LANCZOS` - default, if not set
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

The `watermark_position` property can have one of the following values:

- `c` - center
- `tl` - top left
- `tr` - top right
- `bl` - bottom left
- `br` - bottom right (default, if not set)

The `watermark_size` property examples:

- `100` - cover all image
- `10` - 10 % (default, if not set)

**Response:**

As source we can handle not only **jpg**, **png**, **webp**, **gif**. But almost all graphics format like **bmp**, **ico**, **jp2**, **tiff**, **eps**, **psd**, **pic**, and much more. Feel free to try your files.
We can handle **svg** file too.
And we can do minify **css** and **js** files.
Support for **avif** file is under construction.

The `extra` array is experimental:

- `white` - white color ratio in percentage
