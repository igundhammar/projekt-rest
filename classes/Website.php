<?php

include_once 'config/Database.php';

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


	public function getAllWebsites() : array {
		$stmt = $this->conn->prepare("SELECT * FROM websites");
		if ( ! $this->result = $stmt->execute()) {
			die( 'Fel vid SQL-fråga [' . $this->conn->error . ']' );
		} else {
			$this->result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $this->result;
		}
	}


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


	public function createWebsite(): bool {
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


	public function updateWebsite( $id ): bool {
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