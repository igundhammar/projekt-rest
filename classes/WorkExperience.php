<?php

// Code by Ida Gundhammar 2021-10-28, student at Mittuniversitetet, HT2020.

// Include Database class
include_once 'config/Database.php';

// Create class WorkExperience with properties from the jobs in database such as id, place, title, startdate and enddate as well as properties with the database connection.
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


	// Method to get all jobs from the database. Returns the result as an associative array.
	public function getAllWorkExperiences() : array {
		$stmt = $this->conn->prepare("SELECT * FROM work_experience ORDER BY enddate ASC");
		if ( ! $this->result = $stmt->execute()) {
			die('Fel vid SQL-fråga [' . $this->conn->error . ']');
		} else {
			$this->result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $this->result;
		}
	}


	// Method to get a specific job with id sent. Return the result as an associative array.
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


	// Method to create a new job. Send place, title, startdate, enddate to the database and return true if the query went through.
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


	// Method to update an existing job with id sent. Send place, title, startdate, enddate and set values on the job with the id sent. Return true if the query went through.
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


	// Method to delete job with id sent. Send the id to the database with DELETE-query. Return true if the query went through.
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