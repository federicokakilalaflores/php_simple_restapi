<?php
	// allows any client to read 
	header( "Access-Control-Allow-Origin: *" );
	// return json content type
	header( "Content-Type: application/json; CHARSET=UTF-8" );
	// use post method
	header( "Access-Control-Allow-Method: POST" );
	// specifies how many seconds can be result to be cached
	header( "Access-Control-Max-Age: 3600" );
	// specifies allowed headers
	header( "Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers,
		Authorization, X-Requested-With" );

	include_once('../config/Database.php');
	include_once('../classes/Product.php');

	$database = new Database();
	$conn = $database->connect();

	$product = new Product($conn);

	$data = json_decode( file_get_contents("php://input") );

	if( $data->id != null ){

		$product->id = $data->id;

		if( $product->delete() ){

			// response code 200 - ok
			http_response_code(200);
			echo json_encode( array( "message" => "Product was deleted." ) );

		}else{

			// response code 503 - service unavailable
			http_response_code(503);
			echo json_encode( array( "message" => "Unable to delete product." ) );

		}


	}else{

		// response code 400 - bad request
		http_response_code(400);
		echo json_encode( array( "message" => "Unable to delete. ID is required." ) );

	}


?>