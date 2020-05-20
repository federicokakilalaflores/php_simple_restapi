<?php
	// any client or origin can access
	header( "Access-Control-Allow-Origin: *" );
	// json content type
	header( "Content-Type: application/json" );
	// allow request method
	header( "Access-Control-Allow-Methods: POST" );
	// specifies how many seconds can be result to be cached
	header( "Access-Control-Max-Age: 3600" );
	// specifies allowed headers
	header( "Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers,
		Authorization, X-Requested-With" );

	//include DB classes
	include_once('../config/Database.php');
	include_once('../classes/Product.php');

	//create objects
	$database = new Database();
	$conn = $database->connect();

	$product = new Product($conn);

	$data = json_decode( file_get_contents("php://input") );


	if(
		!empty($data->id) &&
		!empty($data->name) &&
		!empty($data->description) &&
		!empty($data->price) &&
		!empty($data->category_id)
	){

		// set object's property
		$product->id = $data->id; 
		$product->name = $data->name; 
		$product->price = $data->price; 
		$product->description = $data->description; 
		$product->category_id = $data->category_id;

		if($product->update()){

			// response code 200 - ok
			http_response_code(200);
			echo json_encode( array( "message" => "Product was updated." ) );

		}else{

			// response code 503 - service unavailable
			http_response_code(503);
			echo json_encode( array( "message" => "Unable to update product." ) );

		} 

	}else{

		// response code 400 - bad request
		http_response_code(400);
		echo json_encode( array( "message" => "Unable to update. Data is incomplete." ) );

	}

?>