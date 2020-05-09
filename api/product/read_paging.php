<?php
	header( "Access-Control-Allow-Origin: *" );
	header( "Content-Type: application/json; CHARSET=UTF-8" );

	include_once('../config/core.php');
	include_once('../shared/Utilities.php');
	include_once('../config/Database.php');
	include_once('../classes/Product.php');



	$database = new Database();
	$conn = $database->connect();

	$utilities = new Utilities();
	$product = new Product($conn);

	$stmt = $product->readPaging($from_page_num, $records_per_page);
	$results = $stmt->rowCount(); 

	if($results > 0){

		$product_arr = array();
		$product_arr['data'] = array();
		$product_arr['paging'] = array();

		while($row = $stmt->fetch()){

			extract($row);

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

		$totalRecords = $product->count();
		$page_url = $home_url . "/product/read_paging.php?";
		$product_arr['paging'] = $utilities->getPaging(
			$page, 
			$totalRecords, 
			$records_per_page, 
			$page_url
		); 



		// set response code 200 - ok
		http_response_code(200);
		echo json_encode($product_arr); 


	}else{

		// set response code 404 - not found
		http_response_code(404);
		echo json_encode( array( "message" => "Product not found." ) );

	}



?>