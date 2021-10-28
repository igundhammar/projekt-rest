<?php

/** Original code by @MallarMiun on GitHub, Malin Larsson, teacher at Mittuniversitetet.
 * Link to original repository: https://github.com/MallarMiun/Grund-for-webbtjanst
 * Code edited with changes Ida Gundhammar 2021-10-28, student at Mittuniversitetet, HT2020.
 **/


// Include Database and Course-classes
include_once 'config/Database.php';
include_once 'classes/Course.php';

// Headers with settings for REST API
header( 'Access-Control-Allow-Origin: *' );
header( 'Content-Type: application/json' );
header( 'Access-Control-Allow-Methods: GET, PUT, POST, DELETE' );
header( 'Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With' );

// Find what method is sent and store in variable
$method = $_SERVER['REQUEST_METHOD'];


//If there is id parameter in URL then store in variable
if ( isset( $_GET['id'] ) ) {
	$id = $_GET['id'];
}

if ( isset( $_GET['token'] ) ) {
	$sent_token = $_GET['token'];
}


// Create new instances of Database and Course
$database = new Database();
$db       = $database->connect();
$courses  = new Course();


// Switch to execute different tasks
switch ( $method ) {
	case 'GET':
		if ( isset( $id ) ) {
			// If id is sent in URL - get the course with id from database.
			$result = $courses->getSpecificCourse( $id );
		} else {
			// If not, get all courses.
			$result = $courses->getAllCourses();
		}
		//Send HTTP response status code
		if ( sizeof( $result ) > 0 ) {
			//Ok - The request has succeeded
			http_response_code( 200 );
		} else {
			//Store message in variable that there is nothing to get from database
			$result = array( "message" => "There is nothing to get yet" );
		}
		break;


	case 'POST':
		if ( $courses->checkToken( $sent_token ) ) {
			// Get input and set it to properties of class Course
			$data                = json_decode( file_get_contents( "php://input" ) );
			$courses->id         = $data->id;
			$courses->code       = $data->code;
			$courses->name       = $data->name;
			$courses->university = $data->university;
			$courses->startdate  = $data->startdate;
			$courses->enddate    = $data->enddate;
			// If course was created, send HTTP response code and store message in variable
			if ( $courses->createCourse() ) {
				http_response_code( 200 );
				$result = array( "message" => "Created" );
			} else {
				// Else store error message in variable
				$result = array( "message" => "Something went wrong" );
			}
		} else {
			$result = array( "message" => "You are not authorized to make changes" );
		}

		break;


	case 'PUT':
		if ( $courses->checkToken( $sent_token ) ) {
			// If no id is sent with put method, send error message
			if ( ! isset( $id ) ) {
				http_response_code( 400 ); //Bad Request - The server could not understand the request due to invalid syntax.
				$result = array( "message" => "No id is sent" );
			} else {
				// Else get input and store in properties from class Course
				$data                = json_decode( file_get_contents( "php://input" ) );
				$courses->id         = $data->id;
				$courses->code       = $data->code;
				$courses->name       = $data->name;
				$courses->university = $data->university;
				$courses->startdate  = $data->startdate;
				$courses->enddate    = $data->enddate;
				if ( $courses->updateCourse( $id ) ) {
					// Run update course and send HTTP response along with OK message
					http_response_code( 200 ); // Ok
					$result = array( "message" => "Post with code $id is updated" );
				} else {
					http_response_code( 503 ); // Server error
					// Send error message
					$result = array( "Error message" => "Course not updated." );
				}
			}
		} else {
			$result = array( "message" => "You are not authorized to make changes" );
		}
		break;


	case 'DELETE':
		if ($courses->checkToken($sent_token)) {
			// If no id is sent with delete method, send error message
			if ( ! isset( $id ) ) {
				http_response_code( 400 );
				$result = array( "message" => "No id is sent" );
			} else {
				if ( $courses->deleteCourse( $id ) ) {
					// Run delete course and send HTTP response along with OK message
					http_response_code( 200 );
					$result = array( "message" => "Post with id $id is deleted" );
				} else {
					http_response_code( 503 ); // Server error
					// Send error message
					$result = array( "Error message" => "Course not deleted." );
				}
			}
		} else {
			$result = array( "message" => "You are not authorized to make changes" );
		}
		break;
}

// Echo the result of the cases above
echo json_encode( $result );


// Close database connection
$database->close();