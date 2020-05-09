<?php

	class Utilities {

		public function getPaging($page, $totalRecords, $records_per_page, $page_url){

			$paging_arr = array();
			$paging_arr['pages'] = array();
			$total_pages = ceil( $totalRecords / $records_per_page );
			$range = 2;

			$initial_num = ($page - $range);

			$rest_num = ($page + $range) + 1;

			$paging_arr['first'] = ( $page > 1 ) ? $page_url : "";

			for ($i=$initial_num; $i < $rest_num; $i++) { 
				if($i > 0 && $i <= $total_pages ){

					$each_page = array(
						"page" => $i,
						"url" => $page_url . "page=" . $i,
						"isActive" => ($page == $i) ? true : false
					);

					array_push( $paging_arr['pages'], $each_page ); 

				}	
			}

			$paging_arr['last'] = ( $page < $total_pages ) ? $page_url . 
			"page=" . $total_pages : "";


			return $paging_arr;
		}


	}

?>