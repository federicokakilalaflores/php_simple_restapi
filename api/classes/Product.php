<?php

	class Product {

		private $conn;
		private $table_name = "tbl_products";

		public $id;
		public $name;
		public $description;
		public $price;
		public $category_id;
		public $category_name;
		public $created;

		public function __construct($conn){
			$this->conn = $conn;
		}


		public function read(){
			$query = "SELECT c.name as category_name, p.id, p.name, p.description, p.price, 
			p.category_id, p.created " . 
			"FROM " . $this->table_name . " p " . 
			"LEFT JOIN tbl_categories c " . 
			"ON p.category_id = c.id " . 
			"ORDER BY p.created DESC";

			$stmt = $this->conn->prepare($query);

			$stmt->execute();

			return $stmt;
		}


		public function create(){
			$query = "INSERT INTO " . $this->table_name . 
			" (name, price, description, category_id, created) 
			VALUES (:name, :price, :description, :category_id, :created)";  

			$stmt = $this->conn->prepare($query);

			$this->name = htmlspecialchars( strip_tags($this->name) );
			$this->price = htmlspecialchars( strip_tags($this->price) );
			$this->description = htmlspecialchars( strip_tags($this->description) );
			$this->category_id = htmlspecialchars( strip_tags($this->category_id) );
			$this->created = htmlspecialchars( strip_tags($this->created) );

			$stmt->bindParam(':name', $this->name);
			$stmt->bindParam(':price', $this->price);
			$stmt->bindParam(':description', $this->description);
			$stmt->bindParam(':category_id', $this->category_id, PARAM::INT);
			$stmt->bindParam(':created', $this->created);

			if( $stmt->execute() ){
				return true;
			}

			return false; 
		}


		public function readOne(){
			$query = "SELECT c.name as category_name, p.id, p.name, p.description, p.price,
			p.category_id, p.created " . 
			"FROM " . $this->table_name . " p " . 
			"LEFT JOIN 	tbl_categories c " . 
			"ON p.category_id = c.id " . 
			"WHERE p.id = ? LIMIT 0,1";

			$stmt = $this->conn->prepare($query);

			$stmt->bindParam(1, $this->id, PARAM::INT);

			$stmt->execute();

			$row = $stmt->fetch();

			$this->name = $row['name'];
			$this->description = $row['description'];
			$this->price = $row['price'];
			$this->category_id = $row['category_id'];
			$this->category_name = $row['category_name'];

		}


		public function update(){
			$query = "UPDATE " . $this->table_name . " 
			SET name=:name, 
			price=:price, 
			description=:description,
			category_id=:category_id
			WHERE id=:id";

			$stmt = $this->conn->prepare($query);

			$this->name = htmlspecialchars( strip_tags($this->name) );
			$this->price = htmlspecialchars( strip_tags($this->price) );
			$this->description = htmlspecialchars( strip_tags($this->description) );
			$this->category_id = htmlspecialchars( strip_tags($this->category_id) );
			$this->id = htmlspecialchars( strip_tags($this->id) );

			$stmt->bindParam(':name', $this->name);
			$stmt->bindParam(':price', $this->price);
			$stmt->bindParam(':description', $this->description);
			$stmt->bindParam(':category_id', $this->category_id);
			$stmt->bindParam(':id', $this->id);

			if($stmt->execute()){
				return true;
			}

			return false; 

		}

		public function delete(){
			$query = "DELETE FROM " . $this->table_name . " WHERE id=?";

			$stmt = $this->conn->prepare($query);

			$this->id = htmlspecialchars( strip_tags($this->id) );

			$stmt->bindParam(1, $this->id);

			if($stmt->execute()){
				return true;
			}

			return false;

		}

		public function search($keywords){
			$query = "SELECT c.name AS category_name, p.id, p.name, p.description, p.price,
			p.category_id, p.created " . 
			"FROM " . $this->table_name . " p " . 
			"LEFT JOIN tbl_categories c " . 
			"ON p.category_id = c.id " . 
			"WHERE p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ? " .
			"ORDER BY p.created DESC"; 

			$stmt = $this->conn->prepare( $query );

			$keywords = htmlspecialchars( strip_tags( $keywords ) );
			$keywords = "%$keywords%";

			$stmt->bindParam(1, $keywords);
			$stmt->bindParam(2, $keywords);
			$stmt->bindParam(3, $keywords);

			if( $stmt->execute() ){
				return $stmt;
			}

			return false;

		}


		public function readPaging($from_page_num, $records_per_page){
			$query = "SELECT c.name as category_name, p.id, p.name, p.description, p.price, 
			p.category_id, p.created " . 
			"FROM " . $this->table_name . " p " . 
			"LEFT JOIN tbl_categories c " .  
			"ON p.category_id = c.id " . 
			"ORDER BY p.created DESC " . 
			"LIMIT ?,?";

			$stmt = $this->conn->prepare($query);

			$stmt->bindParam(1, $from_page_num, PDO::PARAM_INT);
			$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT); 

			if( $stmt->execute() ){
				return $stmt;
			}

			return false;

		}


		public function count(){
			$query = "SELECT COUNT(id) AS total_rows FROM " . $this->table_name;

			$stmt = $this->conn->prepare( $query );

			$stmt->execute();

			$row = $stmt->fetch();

			return $row['total_rows'];

		}


	}

?>