<?php

// Code by Ida Gundhammar 2021-10-28, student at Mittuniversitetet, HT2020.

// Include Database class
include_once 'config/Database.php';


// Create class Website with properties from the websites in database such as id, title, description and url as well as properties with the database connection.
class Website {

	public $id;
	public $title;
	public $description;
	public $url;
	private $conn;
	private $result;


	// Create instance of Database class and connect to database
	public function __construct() {
		$dbconn     = new Database();
		$this->conn = $dbconn->connect();
	}


	// Method to check if the token sent in GET parameter is found in the database. If it is, return true. Else, return false.
	public function checkToken( $token ) : bool {
		$stmt = $this->conn->prepare("SELECT * FROM users WHERE token = :token");
		$stmt->bindParam(':token', $token);
		if ( ! $this->result = $stmt->execute()) {
			die( 'Fel vid SQL-fråga [' . $this->conn->error . ']' );
		} else {
			if ( $this->result = $stmt->fetchAll( PDO::FETCH_ASSOC ) ) {
				return true;
			} else {
				return false;
			}
		}
	}


	// Method to get all websites from the database. Returns the result as an associative array.
	public function getAllWebsites() : array {
		$stmt = $this->conn->prepare("SELECT * FROM websites");
		if ( ! $this->result = $stmt->execute()) {
			die( 'Fel vid SQL-fråga [' . $this->conn->error . ']' );
		} else {
			$this->result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $this->result;
		}
	}


	// Method to get a specific website with id sent. Return the result as an associative array.
	public function getSpecificWebsite( $id ): array {
		$stmt = $this->conn->prepare("SELECT * FROM websites WHERE id = :id");
		$stmt->bindParam(':id', $id);
		if ( ! $this->result = $stmt->execute()) {
			die( 'Fel vid SQL-fråga [' . $this->conn->error . ']' );
		} else {
			$this->result = $stmt->fetchAll( PDO::FETCH_ASSOC );
			return $this->result;
		}
	}


	// Method to create a new website. Send title, description and url to the database and return true if the query went through.
	public function createWebsite(): bool {
		$this->title = htmlspecialchars($this->title);
		$this->description = htmlspecialchars($this->description);
		$this->url = htmlspecialchars($this->url);
		$stmt = $this->conn->prepare( "INSERT INTO websites (title, description, url)
		VALUES (:title, :description, :url)" );
		$stmt->bindParam( ':title', $this->title );
		$stmt->bindParam( ':description', $this->description );
		$stmt->bindParam( ':url', $this->url );
		if ( ! $this->result = $stmt->execute() ) {
			die( 'Fel vid SQL-fråga [' . $this->conn->error . ']' );
		} else {
			return true;
		}
	}


	// Method to update an existing website with id sent. Send title, description and url and set values on the website with the id sent. Return true if the query went through.
	public function updateWebsite( $id ): bool {
		$this->title = htmlspecialchars($this->title);
		$this->description = htmlspecialchars($this->description);
		$this->url = htmlspecialchars($this->url);
		$stmt = $this->conn->prepare("UPDATE websites SET title = :title, description = :description, url = :url WHERE id = :id");
		$stmt->bindParam( ':title', $this->title );
		$stmt->bindParam( ':description', $this->description );
		$stmt->bindParam( ':url', $this->url );
		$stmt->bindParam(':id', $id);
		if ( ! $this->result = $stmt->execute()) {
			die( 'Fel vid SQL-fråga [' . $this->conn->error . ']' );
		} else {
			return true;
		}
	}


	// Method to delete website with id sent. Send the id to the database with DELETE-query. Return true if the query went through.
	public function deleteWebsite( $id ): bool {
		$stmt = $this->conn->prepare("DELETE FROM websites WHERE id = :id");
		$stmt->bindParam(':id', $id);
		if ( ! $this->result = $stmt->execute()) {
			die( 'Fel vid SQL-fråga [' . $this->conn->error . ']' );
		} else {
			return true;
		}
	}
}