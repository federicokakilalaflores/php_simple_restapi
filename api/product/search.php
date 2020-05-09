<?php
	header( "Access-Control-Allow-Origin: *" );
	header( "Content-Type: application/json; CHARSET=UTF-8" );

	include_once('../config/core.php');
	include_once('../config/Database.php');
	include_once('../classes/Product.php');

	$database = new Database();
	$conn = $database->connect();

	$product = new Product($conn);

	$keywords = isset( $_GET['s'] ) ? $_GET['s'] : "";

	$stmt = $product->search( $keywords );
	$totalRecords = $stmt->rowCount();

	if( $totalRecords > 0 ){

		$product_arr = array();
		$product_arr['data']  = array();

		while( $row = $stmt->fetch() ) {

			extract( $row );

			$product_item = array(
				"id" => $id,
				"name" => $name,
				"description" => $description,
				"price" => $price,
				"category_id" => $category_id,
				"category_name" => $category_name
			);

			array_push($product_arr['data'], $product_item);

		}

		// response code - ok
		http_response_code(200);
		echo json_encode($product_arr);

	}else{

		// response code 404 - not found
		http_response_code(404);
		echo json_encode( array( "message" => "Product not found." ) );

	}

?>