<?php
namespace Monitor;

require_once "Flags.php";

class CMD {
	private const ALLOWED_ARGV = array(
		'group_id',
		'event',
		'flag' => array(
			'create',
			'finish'
		),
		'config'
	);

	private $arguments = array();

	public function __construct($arguments)
	{
		$this->arguments = $this->parseArgv($arguments);
	}

	public function parseArgv($arguments)
	{
		$result = array();

		parse_str(implode('&', array_slice($arguments, 1)), $result);

		$this->checkAllowedArgv($result);

		return $result;
	}

	public function checkAllowedArgv($arguments)
	{
		foreach($arguments as $key => $value) {
			if(!in_array($key, self::ALLOWED_ARGV) && !isset(self::ALLOWED_ARGV[$key])) {
				throw new \Error("Unknown argument `$key`");
			}

			if(gettype(self::ALLOWED_ARGV[$key]) === 'array') {
				if(!in_array($value, self::ALLOWED_ARGV[$key])) {
					throw new \Error("Unknown value `$value` for argument `$key`");
				}
			}
		}
	}
	
	public function getGroupId()
	{
		return $this->arguments['group_id'];
	}

	public function getEvent()
	{
		return $this->arguments['event'];
	}

	public function getFlag()
	{
		switch($this->arguments['flag']) {
			case 'create':
				return Flags::LOG_CREATED;
				break;
			case 'finish':
				return Flags::LOG_FINISHED;
				break;
			default:
				return Flags::LOG_GENERAL;
		}
	}

	public function getConfig()
	{
		return $this->arguments['config'];
	}
}