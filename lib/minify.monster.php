<?php
class Monster {
	protected $apiKey;
	public function __construct($apiKey=NULL) {
		$this->apiKey = $apiKey;
	}
	public function minify($params=NULL) {
		if (empty($params)) {
			$result=[
				'success' => false,
				'message' => 'empty params'
			];
		} else {
			if ($params['from_url'] === true) {
				$result = $this->transformImage(array_merge($params, ['apikey' => $this->apiKey]));
			} else {
				if (file_exists($params['url'])) {
					$upload = $this->uploadFile($params['url']);
					if ($upload['success'] === true) {
						$params = array_merge($params, ['apikey' => $this->apiKey, 'row' => $upload['row'], 'fingerprint' => $upload['fingerprint']]);
						$result = $this->transformImage($params);
					} else {
						$result = $upload;
					}
				} else {
					$result=['success'=>false, 'message'=>'file does not exists'];
				}
			}
		}
		return json_encode($result);
	}
	public function uploadFile($filename=NULL) {
		if (class_exists('CURLFile')) {
			$file = new CURLFile($filename);
		} else {
			$file = '@' . $filename;
		}
		$data = [
			'apiKey' => $this->apiKey,
			'file' => $file
		];
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://upload.minify.monster');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$response = curl_exec($ch);
		if (curl_errno($ch)) {
			$curl_error = curl_error($ch);
		}
		curl_close($ch);
		if (isset($curl_error)) {
			$result=[
				'success' => false,
				'message' => $curl_error
			];
		} else {
			$result = json_decode($response, true);
		}
		return $result;
	}
	public function transformImage($data=NULL) {
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, 'https://api.minify.monster');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$response = curl_exec($ch);
		if (curl_errno($ch)) {
			$curl_error = curl_error($ch);
		}
		curl_close($ch);
		if (isset($curl_error)) {
			$result=[
				'success' => false,
				'message' => $curl_error
			];
		} else {
			$transform = json_decode($response, true);
			if ($transform['success'] === true) {
				$result=[
					'success' => true,
					'images' => $transform['images'],
					'extra' => $transform['extra']
				];
			} else {
				$result=[
					'success' => false,
					'message' => $transform['message']
				];
			}
		}
		return $result;
	}
}