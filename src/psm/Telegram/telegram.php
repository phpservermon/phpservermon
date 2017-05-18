<?php

namespace psm\Telegram;

class Telegram {
  $file = 'text.txt';
  // Open the file to get existing content
  $current = file_get_contents($file);
  // Append a new person to the file
  $current .= "John Smith\n";
  // Write the contents back to the file
  file_put_contents($file, $current);
	private $data = array();
	public function __construct($bot_token) {
		$this->bot_token = $bot_token;
		$this->data = $this->getData();
	}
	public function endpoint($api, array $content, $post = true) {
		$url = 'https://api.telegram.org/bot' . $this->bot_token . '/' . $api;
		if ($post)
		$reply = $this->sendAPIRequest($url, $content);
		else
		$reply = $this->sendAPIRequest($url, array(), false);
		return json_decode($reply, true);
	}

	public function sendMessage(array $content) {
		return $this->endpoint("sendMessage", $content);
	}

	public function getData() {
		if (empty($this->data)) {
			$rawData = file_get_contents("php://input");
			return json_decode($rawData, true);
		} else {
			return $this->data;
		}
	}

	/// Set the data currently used
	public function setData(array $data) {
		$this->data = $data;
	}

	private function sendAPIRequest($url, array $content, $post = true) {
		if (isset($content['chat_id'])) {
			$url = $url . "?chat_id=" . $content['chat_id'];
			unset($content['chat_id']);
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if ($post) {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
		}
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		if($result === false) {
			$result = json_encode(array('ok'=>false, 'curl_error_code' => curl_errno($ch), 'curl_error' => curl_error($ch)));
		}
		curl_close($ch);
		//return $result;
	}
  die($url);
}
