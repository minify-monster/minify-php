<?php
/**
Minify image from URL to 2 files - jpg and webp. And save them to local storage.
With same dimensions as original.
*/

require_once __DIR__.'/minify.monster.php';

$data=[
	'url' => 'https://site-url.com/file.jpg',
	'from_url' => true,
	'images' => [
		[
			'extension' => 'jpg'
		],[
			'extension' => 'webp'
		]
	]
];

$monster = new Monster('your-api-key');
$response = $monster->minify($data);
$result = json_decode($response, true);

if ($result['success'] === true) {
	// path to save optimized images
	$save_name = [
		__DIR__.'/images/result.jpg',
		__DIR__.'/images/result.webp'
	];
	$row=0;
	// save all images
	foreach ($result['images'] as $file) {
		$ch = curl_init();
		$fp = fopen($save_name[$row], "w");
		curl_setopt($ch, CURLOPT_URL, $file);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_FILE, $fp);
		$curl_result = curl_exec($ch);
		$errorCode = curl_errno($ch);
		curl_close($ch);
		fclose($fp);
		if (empty($errorCode)) {
			echo "File ".$save_name[$row]." saved.<br/>";
		} else {
			echo "Error save file ".$save_name[$row]."<br/>";
		}
		$row++;
	}
} else {
	echo "Error: ".$result['message'];
}
