<?php
/**
 * php-pushover
 *
 * https://github.com/kryap/php-pushover
 *
 * PHP service wrapper for the pushover.net API: https://pushover.net/api
 *
 * @author Chris Schalenborgh <chris.s@kryap.com>
 * @version 0.2
 * @package php-pushover
 * @example test.php
 * @link https://pushover.net/api
 * @license BSD License
 */

class Pushover
{
	// api url
	const API_URL = 'https://api.pushover.net/1/messages.xml';

	/**
	 * Application API token
	 *
	 * @var string
	 */
	private $_token;

	/**
	 * User API token
	 *
	 * @var string
	 */
	private $_user;

	/**
	 * Turn on/off debug mode
	 *
	 * @var bool
	 */
	private $_debug = false;

	/**
	 * Title of the message
	 *
	 * @var string
	 */
	private $_title;

	/**
	 * The message itself (up to 512 characters)
	 *
	 * @var string
	 */
	private $_message;

	/**
	 * Timestamp in Unix timestamp format
	 *
	 * @var int
	 */
	private $_timestamp;

	/**
	 * User's device (user specific)
	 *
	 * @var string
	 */
	private $_device;

	/**
	 * Priority of the message. Can be 0, 1 or 2. High-priority messages (1) override a user's "quiet hours" setting and will always be delivered any time they are received. High priority messages are highlighted in red in the Android and iOS clients. Emergency Priority (2) messages work similar to High-Priority messages, but they are repeated until the message is acknowledged by the user.
	 *
	 * @var string
	 */
	private $_priority = 0;

	/**
	 * Include a Supplementary URL (up to 200 characters)
	 *
	 * @var string
	 */
	private $_url;

	/**
	 * Title of the included URL (up to 50 characters)
	 *
	 * @var string
	 */
	private $_url_title;

	/**
	 * The Retry parameter is only used when the Priority is set to 2 (or emergency-priority), and specifies how often (in seconds) the Pushover servers will send the same notification to the user. In a situation where your user might be in a noisy environment or sleeping, retrying the notification (with sound and vibration) will help get his or her attention. This parameter must have a value of at least 30 seconds between retries.
	 *
	 * @var int
	 */
	private $_retry;

	/**
	* The expire parameter is only used when the Priority is set to 2 (or emergency-priority), and specifies how many seconds your notification will continue to be retried for. If the notification has not been acknowledged in expire seconds, it will be marked as expired and will stop being sent to the user. This parameter must have a maximum value of at most 86400 seconds (24 hours).
	*
	* @var int
	*/
	private $_expire;

	/**
	 * The optional callback parameter may be supplied with a publicly-accessible URL that our servers will send a request to when the user has acknowledged your notification.
	 *
	 * @var string
	 */
	private $_callback;

	/**
	* The sound parameter. Get an up-to-date sound list from https://api.pushover.net/1/sounds.json?token=
	*
	* @var int
	*/
	private $_sound;

	/**
	 * Default constructor
	 */
	public function __construct () {
    }

	/**
	 * Set API token
	 *
	 * @param string $token Your app API key.
	 *
	 * @return void
	 */
    public function setToken ($token) {
        $this->_token = (string)$token;
    }

	/**
	 * Get API token
	 *
	 * @return string
	 */
    public function getToken () {
        return $this->_token;
    }

	/**
	 * Set API user
	 *
	 * @param string $user The user's API key.
	 *
	 * @return void
	 */
    public function setUser ($user) {
        $this->_user = (string)$user;
    }

	/**
	 * Get API user
	 *
	 * @return string
	 */
    public function getUser () {
        return $this->_user;
    }

	/**
	 * Set message title
	 *
	 * @param string $title Title of push notification.
	 *
	 * @return void
	 */
    public function setTitle ($title) {
        $this->_title = (string)$title;
    }

	/**
	 * Get message title
	 *
	 * @return string
	 */
    public function getTitle () {
        return $this->_title;
    }

	/**
	 * Set Retry Time
	 *
	 * @param int $retry The retry time (in seconds). Must have a value of at least 30 seconds.
	 */
	public function setRetry ($retry) {
		$this->_retry = (int)$retry;
	}

	/**
	 * Get Retry Time
	 *
	 * @return int
	 */
	public function getRetry() {
		return $this->_retry;
	}

	/**
	 * Set Expire Time
	 *
	 * @param int $expire The expiry time (in seconds). Must have a maximum value of at most, 86400 seconds.
	 */
	public function setExpire ($expire) {
		$this->_expire = (int)$expire;
		}

	/**
	 * Get Expire Time
	 *
	 * @return string
	 */
    public function getExpire () {
        return $this->_expire;
    }

	/**
	 * Set Callback URL
	 *
	 * @param string $callback a publically-accessible URL that Pushover sends a request to when the user has acknowledged your notification.
	 */
	public function setCallback ($callback) {
		$this->_callback = $callback;
	}

	/**
	 * Get Callback URL
	 *
	 * @return int
	 */
	public function getCallback() {
		return $this->_callback;
	}

	/**
	 * Set message
	 *
	 * @param string $msg Message of push notification.
	 *
	 * @return void
	 */
    public function setMessage ($msg) {
        $this->_message = (string)$msg;
    }

	/**
	 * Get message
	 *
	 * @return string
	 */
    public function getMessage () {
        return $this->_message;
    }

	/**
	 * Set device
	 *
	 * @param string $device Leave this empty if you want to send to all user's devices. This can be user specific!
	 *
	 * @return void
	 */
    public function setDevice ($device) {
        $this->_device = (string)$device;
    }

	/**
	 * Get device
	 *
	 * @return string
	 */
    public function getDevice () {
        return $this->_device;
    }

	/**
	 * Set timestamp
	 *
	 * Messages are stored on the Pushover servers with a timestamp of when they were initially received through the API. This timestamp is sent to and shown on client devices, and messages are listed in order of these timestamps. In most cases, this default timestamp is acceptable. This is not for scheduling!
	 *
	 * @param int $time dispaly time on device
	 *
	 * @return void
	 */
    public function setTimestamp ($time) {
        $this->_timestamp = (int)$time;
    }

	/**
	 * Get timestamp
	 *
	 * @return int
	 */
    public function getTimestamp () {
        return $this->_timestamp;
    }

	/**
	 * Set priority (-1, 0 or 1)
	 *
	 * -1 Low priority notifications.
	 * 0  Default.
	 * 1 triggers a high-priority alert that always generates sound and vibration.
	 * 2 triggers the same high-priority alert that #1 does; but is repeated until the notification is acknowledged by the user.
	 *
	 * @param int $priority priority level.
	 *
	 * @return void
	 */
    public function setPriority ($priority) {
        $this->_priority = (int)$priority;
    }

	/**
	 * Get priority
	 *
	 * @return int
	 */
    public function getPriority () {
        return $this->_priority;
    }

	/**
	 * Set url
	 *
	 * @param string $url Add an url to your notification.
	 *
	 * @return void
	 */
    public function setUrl ($url) {
        $this->_url = (string)$url;
    }

	/**
	 * Get url
	 *
	 * @return string
	 */
    public function getUrl () {
        return $this->_url;
    }

	/**
	 * Set url title
	 *
	 * @param string $url_title A title if you want to show a text instead of the actual url.
	 *
	 * @return void
	 */
    public function setUrlTitle ($url_title) {
        $this->_url_title = (string)$url_title;
    }

	/**
	 * Get url title
	 *
	 * @return string
	 */
    public function getUrlTitle () {
        return $this->_url_title;
    }

	/**
	 * Set debug mode
	 *
	 * @param bool $debug Enable this to receive detailed input and output info.
	 *
	 * @return void
	 */
    public function setDebug ($debug) {
        $this->_debug = (boolean)$debug;
    }

	/**
	 * Get debug mode
	 *
	 * @return bool
	 */
    public function getDebug () {
        return $this->_debug;
    }

	/**
	 * Set sound
	 *
	 * @param string $sound If no sound parameter is specified, the user's default tone will play. If the user has not chosen a custom sound, the standard Pushover sound will play.
	 *
	 * @return void
	 */
    public function setSound ($sound) {
        $this->_sound = (string)$sound;
    }

	/**
	 * Get sound
	 *
	 * @return string
	 */
    public function getSound () {
        return $this->_sound;
    }

	/**
	 * Send message to Pushover API
	 *
	 * @return bool
	 */
	public function send() {
		if(!Empty($this->_token) && !Empty($this->_user) && !Empty($this->_message)) {
			if(!isset($this->_timestamp)) $this->setTimestamp(time());

			$c = curl_init();
			curl_setopt($c, CURLOPT_URL, self::API_URL);
			curl_setopt($c, CURLOPT_HEADER, false);
			/*
			if possible, set CURLOPT_SSL_VERIFYPEER to true..
			- http://www.tehuber.com/phps/cabundlegen.phps
			*/
			curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($c, CURLOPT_POSTFIELDS, array(
			  	'token' => $this->getToken(),
			  	'user' => $this->getUser(),
			  	'title' => $this->getTitle(),
			  	'message' => $this->getMessage(),
			  	'device' => $this->getDevice(),
			  	'priority' => $this->getPriority(),
			  	'timestamp' => $this->getTimestamp(),
				'expire' => $this->getExpire(),
				'retry' => $this->getRetry(),
				'callback' => $this->getCallback(),
			  	'url' => $this->getUrl(),
			  	'sound' => $this->getSound(),
			  	'url_title' => $this->getUrlTitle()
			));
			$response = curl_exec($c);
			$xml = simplexml_load_string($response);

			if($this->getDebug()) {
				return array('output' => $xml, 'input' => $this);
			}
			else {
				return ($xml->status == 1) ? true : false;
			}
		}
	}
}
?>