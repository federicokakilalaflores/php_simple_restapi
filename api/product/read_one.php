<?php
	// any client can read or access
	header( "Access-Control-Allow-Origin: *" );
	// return a json content type
	header( "Content-Type: application/json; CHARSET=UTF-8" );
	// get request for fetching data
	header( "Access-Control-Allow-Methods: GET" );
	// allow credentials
	header( "Access-Control-Allow-Credentials: true" );
	// allowed headers
	header( "Access-Control-Allow-Headers: Access" );
	
	include_once('../config/Database.php');
	include_once('../classes/Product.php');

	$database = new Database();
	$conn = $database->connect();

	$product = new Product($conn);

	$product->id = isset($_GET['id']) ? $_GET['id'] : die();

	$product->readOne();

	if($product->name != null){

		$product_arr = array(
			"id" => $product->id,
			"name" => $product->name,
			"price" => $product->price,
			"description" => $product->description,
			"category_id" => $product->category_id,
			"category_name" => $product->category_name
		);

		// response code 200 - OK
		http_response_code(200);
		echo json_encode( $product_arr ); 

	}else{

		// response code 404 - not found
		http_response_code(404);
		echo json_encode( array( "message" => "Product not Found." ) );

	}

?>