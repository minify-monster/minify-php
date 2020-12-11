<?php
/**
Minify image from local file to jpg.
Change size to max. 1280px.
*/

require_once __DIR__.'/minify.monster.php';

$data=[
	'url' => '/var/www/your-site/file.jpg',
	'images' => [
		[
			'extension' => 'jpg',
			'width' => 1280,
			'height' => 1280
		]
	]
];

$monster = new Monster('your-api-key');
$response = $monster->minify($data);
$result = json_decode($response, true);

if ($result['success'] === true) {
	echo "Success. Image URL: ".$result['images'][0];
} else {
	echo "Error: ".$result['message'];
}
