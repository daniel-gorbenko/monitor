<?php

namespace Monitor;

require_once "Flags.php";

class Client
{
	private $api_url;
	private $username;
	private $password;
	private $application_id;

	public function __construct($config)
	{
		$this->api_url = $config->api_url;
		$this->username = $config->username;
		$this->password = $config->password;
		$this->application_id = $config->application_id;
	}

	public function log($group_id, $event, $flag = Flags::LOG_GENERAL)
	{
		$data = array(
			'username' => $this->username,
			'password' => $this->password,
			'application_id' => $this->application_id,
			'group_id' => $group_id,
			'author_id' => $this->author_id,
			'event' => $event,
			'flag' => $flag,
			'datetime' => $this->getCurrentDatetime(),
		);

		$this->request('log', $data);
	}
	
	private function getCurrentDatetime()
	{
		return time();
	}

	private function request($method, $data)
	{
		$options = array(
			"http" => array(
				"method" => "POST",
				"header" => "Content-type: application/json; charset=UTF-8\r\n"
					."Accept: application/json, */*\r\n",
				"content" => http_build_query($data),
			)
		);

		$context = stream_context_create($options);
		$result = file_get_contents($this->api_url . $method, false, $context);

		$json = json_decode($result);

		var_dump($json);
	}

	public static function getConfig($path_to_config)
	{
		return json_decode(file_get_contents($path_to_config));
	}
}