<?php
	// access control and return json content
	header( "Access-Control-Allow-Origin: *" );
	header( "Content-Type: application/json; CHARSET=UTF-8" ); 

	include_once('../config/core.php');
	include_once('../config/Database.php');
	include_once('../classes/Product.php');

	$database = new Database();
	$conn = $database->connect();

	$product = new Product($conn);

	$stmt = $product->read();
	$totalRecords = $stmt->rowCount();

	if( $totalRecords > 0 ){ 
		
		$productArr = array();
		$productArr['data'] = array();

		while( $row = $stmt->fetch() ){ 

			extract( $row );

			$productItem = array(
				"id" => $id,
				"name" => $name,
				"description" => $description,
				"price" => $price,
				"category_id" => $category_id,
				"category_name" => $category_name
			);

			array_push($productArr['data'], $productItem);

		}

		// set response code - 200 means "ok"
		http_response_code(200);
		echo json_encode($productArr);

	}else{

		// set response code - 404 means "not found"
		http_response_code(404);
		echo json_encode(array("message" => "No products found."));
	}	
	
?>