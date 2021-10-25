<?php


// Code by Ida Gundhammar 2021-10-07, student at Mittuniversitetet, HT2020.

// Create class Database with properties of the database host, name, username and password.
class Database {

	private $host = '[dbhost]';
	private $db_name = '[dbname]';
	private $username = '[username]';
	private $password = '[password]';



	// Connect to database with given properties. Return error message if there was a connection problem, if not return the connection to property dbconn.
	public function connect() {
		$this->dbconn = null;

		try {
			$this->dbconn = new PDO( 'mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password );
			$this->dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Connection error
		} catch (PDOException $e) {
			echo "Connection error: " . $e->getMessage();
		}
		return $this->dbconn;
	}

	// Close database connection
	public function close() {
		$this->dbconn = null;
	}
}