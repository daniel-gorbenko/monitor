<?php

namespace Monitor;

class Client
{
	public const FLAG_GENERAL = 0;
	public const FLAG_CREATED = 1;
	public const FLAG_FINISHED = 2;

	private $public_key;
	private $application_id;
	private $author_id;
	private $api_url;

	public function __construct($application_id, $public_key, $api_url)
	{
		$this->public_key = $public_key;
		$this->application_id = $application_id;
		$this->api_url = $api_url;

		$this->author_id = $this->getAuthorId($public_key);
	}

	public function log($group_id, $event, $flag = self::FLAG_GENERAL)
	{
		$data = array(
			'application_id' => $this->application_id,
			'group_id' => $group_id,
			'author_id' => $this->author_id,
			'event' => $event,
			'flag' => $flag,
			'datetime' => $this->getCurrentDatetime(),
		);

		$this->request($data);
	}
	
	private function getCurrentDatetime()
	{
		return time();
	}

	private function request($data)
	{
		$json = json_encode($data);

		echo $this->api_url;
		
		var_dump($json);
	}

	private function getAuthorId($public_key)
	{
		return 'author_id: ' . $public_key;
	}
}