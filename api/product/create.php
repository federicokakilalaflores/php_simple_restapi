<?php
	// can be read by anyone using (asterisk *)
	header( "Access-Control-Allow-Origin: *" );
	// return json content type
	header( "Content-Type: application/json; CHARSET=UTF-8" );
	// only allow POST method
	header( "Access-Control-Allow-Method: POST" );
	// specifies how many seconds can be result to be cached	
	header( "Access-Control-Max-Age: 3600" );
	// it specifies the supported request header
	header( "Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, 
		Authorization, X-Requested-With " );

	// include DB and classes
	include_once('../config/Database.php');	
	include_once('../classes/Product.php');	

	$database = new Database();
	$conn = $database->connect();

	$product = new Product($conn);

	/*
		return

		stdClass Object
		(
		    [name] => I Phone 8s
		    [price] => 7000
		    [description] => Elegant and portable device with face unclock.
		    [category_id] => 4
		    [created] => 2020-06-24 00:45:12
		)
	*/
	$data = json_decode( file_get_contents("php://input") ); 

	if(
		!empty( $data->name ) &&
		!empty( $data->price ) &&
		!empty( $data->description ) &&
		!empty( $data->category_id ) 
	){

		$product->name = $data->name;
		$product->price = $data->price;
		$product->description = $data->description;
		$product->category_id = $data->category_id;
		$product->created = date("Y-m-d H:i:s");

		if($product->create()){

			// response code 201 = created
			http_response_code(201);
			echo json_encode( array( "message" => "Product was created" ) );

		}else{

			// response code 503 - service unavailable
			http_response_code(503);
			echo json_encode( array( "message" => "Unable to create product." ) );

		}


	}else{

		// response code 400 = bad request
		http_response_code(400);
		echo json_encode( array( "message" => "Unable to create. Data is Incomplete." ) );

	}

	  

?>