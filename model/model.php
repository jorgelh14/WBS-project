<?php
require_once('connection.php');

abstract class Model
{
	protected $conn;

	public function __construct() 
	{
		$connection = Connection::get_instance();
		$this->conn = $connection->get_connection();
	}

	public function sanitize_string($string)
	{
		$string = stripcslashes($string);
		$string = $this->conn->real_escape_string($string);
		return htmlentities($string);
	}
	
	public function sanitize_array($array) 
	{
		$sanitized_array = array();
		foreach($array as $key => $value)
		{
			$sanitized_array[$key] = $this->sanitize_string($value);
		}
		return $sanitized_array;
	}
	
}

?>