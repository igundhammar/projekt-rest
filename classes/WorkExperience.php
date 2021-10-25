<?php

include_once 'config/Database.php';

class WorkExperience {

	public $id;
	public $place;
	public $title;
	public $startdate;
	public $enddate;
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


	public function getAllWorkExperiences() : array {
		$stmt = $this->conn->prepare("SELECT * FROM work_experience ORDER BY enddate ASC");
		if ( ! $this->result = $stmt->execute()) {
			die('Fel vid SQL-fråga [' . $this->conn->error . ']');
		} else {
			$this->result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $this->result;
		}
	}


	public function getSpecificWorkExperience( $id ): array {
		$stmt = $this->conn->prepare("SELECT * FROM work_experience WHERE id = :id");
		$stmt->bindParam(':id', $id);
		if ( ! $this->result = $stmt->execute() ) {
			die( 'Fel vid SQL-fråga [' . $this->conn->error . ']' );
		} else {
			$this->result = $stmt->fetchAll( PDO::FETCH_ASSOC );
			return $this->result;
		}
	}


	public function createWorkExperience(): bool {
		$stmt = $this->conn->prepare("INSERT INTO work_experience (place, title, startdate, enddate)
		VALUES (:place, :title, :startdate, :enddate)");
		$stmt->bindParam( ':place', $this->place );
		$stmt->bindParam( ':title', $this->title );
		$stmt->bindParam( ':startdate', $this->startdate );
		$stmt->bindParam( ':enddate', $this->enddate );
		if ( ! $this->result = $stmt->execute()) {
			die( 'Fel vid SQL-fråga [' . $this->conn->error . ']' );
		} else {
			return true;
		}
	}


	public function updateWorkExperience( $id ): bool {
		$stmt = $this->conn->prepare("UPDATE work_experience SET place = :place, title = :title, startdate = :startdate, enddate = :enddate WHERE id = :id");
		$stmt->bindParam( ':place', $this->place );
		$stmt->bindParam( ':title', $this->title );
		$stmt->bindParam( ':startdate', $this->startdate );
		$stmt->bindParam( ':enddate', $this->enddate );
		$stmt->bindParam(':id', $id);
		if ( ! $this->result = $stmt->execute()) {
			die( 'Fel vid SQL-fråga [' . $this->conn->error . ']' );
		} else {
			return true;
		}
	}


	public function deleteWorkExperience( $id ): bool {
		$stmt = $this->conn->prepare("DELETE FROM work_experience WHERE id = :id");
		$stmt->bindParam(':id', $id);
		if ( ! $this->result = $stmt->execute()) {
			die( 'Fel vid SQL-fråga [' . $this->conn->error . ']' );
		} else {
			return true;
		}
	}
}