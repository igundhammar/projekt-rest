<?php

// Code by Ida Gundhammar 2021-10-28, student at Mittuniversitetet, HT2020.


// Include Database class
include_once 'config/Database.php';


// Create class Course with properties from the courses in database such as id, code, name, university, startdate and enddate as well as properties with the database connection.
class Course {

	public $id;
	public $code;
	public $name;
	public $university;
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


	// Method to get all courses from the database. Returns the result as an associative array.
	public function getAllCourses(): array {
		$stmt = $this->conn->prepare( "SELECT * FROM courses ORDER BY enddate DESC " );
		if ( ! $this->result = $stmt->execute() ) {
			die( 'Fel vid SQL-fråga [' . $this->conn->error . ']' );
		} else {
			$this->result = $stmt->fetchAll( PDO::FETCH_ASSOC );
			return $this->result;
		}
	}


	// Method to get a specific course with id sent. Return the result as an associative array.
	public function getSpecificCourse( $id ): array {
		$stmt = $this->conn->prepare( "SELECT * FROM courses WHERE id = :id" );
		$stmt->bindParam( ':id', $id );
		if ( ! $this->result = $stmt->execute() ) {
			die( 'Fel vid SQL-fråga [' . $this->conn->error . ']' );
		} else {
			$this->result = $stmt->fetchAll( PDO::FETCH_ASSOC );

			return $this->result;
		}
	}


	// Method to create a new course. Send code, name, university, startdate and enddate to the database and return true if the query went through.
	public function createCourse(): bool {
		$this->code = htmlspecialchars($this->code);
		$this->name = htmlspecialchars($this->name);
		$this->university = htmlspecialchars($this->university);
		$stmt = $this->conn->prepare( "INSERT INTO courses (code, name, university, startdate, enddate) VALUES (:code, :name, :university, :startdate, :enddate)" );
		$stmt->bindParam( ':code', $this->code );
		$stmt->bindParam( ':name', $this->name );
		$stmt->bindParam( ':university', $this->university );
		$stmt->bindParam( ':startdate', $this->startdate );
		$stmt->bindParam( ':enddate', $this->enddate );
		if ( ! $this->result = $stmt->execute() ) {
			die( 'Fel vid SQL-fråga [' . $this->conn->error . ']' );
		} else {
			return true;
		}
	}


	// Method to update an existing course with id sent. Send code, name, university, startdate and enddate and set values on the course with the id sent. Return true if the query went through.
	public function updateCourse( $id ): bool {
		$this->code = htmlspecialchars($this->code);
		$this->name = htmlspecialchars($this->name);
		$this->university = htmlspecialchars($this->university);
		$stmt = $this->conn->prepare( "UPDATE courses SET code = :code, name = :name, university = :university, startdate = :startdate, enddate = :enddate WHERE id = :id" );
		$stmt->bindParam( ':code', $this->code );
		$stmt->bindParam( ':name', $this->name );
		$stmt->bindParam( ':university', $this->university );
		$stmt->bindParam( ':startdate', $this->startdate );
		$stmt->bindParam( ':enddate', $this->enddate );
		$stmt->bindParam( ':id', $id );
		if ( ! $this->result = $stmt->execute() ) {
			die( 'Fel vid SQL-fråga [' . $this->conn->error . ']' );
		} else {
			return true;
		}
	}


	// Method to delete course with id sent. Send the id to the database with DELETE-query. Return true if the query went through.
	public function deleteCourse( $id ): bool {
		$stmt = $this->conn->prepare( "DELETE FROM courses WHERE id = :id" );
		$stmt->bindParam( ':id', $id );
		if ( ! $this->result = $stmt->execute() ) {
			die( 'Fel vid SQL-fråga [' . $this->conn->error . ']' );
		} else {
			return true;
		}
	}
}