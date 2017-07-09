<?php
/**
 * Config class
 * Defines all required configurations
 * 
 * @package src
 * @version 1.0.0
 */
class Config {
	private $_config;
	public function __construct($settings = null) {
		$this->_config = array(
			"DB_USERNAME"		=> "root",
			"DB_PASSWORD"		=> "",
			"DB_NAME"			=> "fb-app",
			"DB_HOST"			=> "localhost",
			"FB_APP_ID"			=> "13298XXXXXX4408",
			"FB_SECRET_KEY"		=> "0d5c75XXXXXXXXXXX3df049ec9de4de4c"
		);
	}

	public function getConfig($key = '') {
		return $key ? $this->_config[$key] : '';
	}

	public function getAllConfig() {
		return $this->_config;
	}

	public function getSiteURL() {
		// output: /myproject/index.php
	    $currentPath = $_SERVER['PHP_SELF']; 

	    // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
	    $pathInfo = pathinfo($currentPath); 

	    // output: localhost
	    $hostName = $_SERVER['HTTP_HOST']; 

	    // output: http://
	    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';

	    // return: http://localhost/myproject/
	    return $protocol.'://'.$hostName.$pathInfo['dirname']."/";
	}
}