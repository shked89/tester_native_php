<?php


namespace App\Services;
use App\Config\MariaDBCon;
use App\Config\ClickhouseDBCon;

trait URLsArray {

	public $urls_array = [];
	public $max_urls_items = 10;

	public function __construct() {

		for ($i=1; $i <= $this->max_urls_items; $i++) { 
			$this->urls_array['get/'.$i] = $this->GetStrFromInt( $i );
		}

	}

	public function GetArrayItem($item_name){
		$max_items = $this->max_urls_items;

		if( !isset($this->urls_array[$item_name]) )
			return false;
		
		return $this->urls_array[$item_name];

	}

	public function GetAllURLs(){
		return $this->urls_array;
	}

	public function GetAllURLKeys(){
		return array_keys( $this->urls_array );
	}

	public function GetStrFromInt( $num ){
		$num = ($num + 116.78) * 1.612593;
		$num = explode('.', $num)[1];
		$str = substr($num, 1, $num % 5);
		$str_1 = base_convert($str, 10, 32);

		
		$num = ($num + 116.28) * 2.612555;
		$num = explode('.', $num)[1];
		$str = substr($num, 1, 5) . ($num^2);
		$str_2 = base_convert($str, 10, 32);
		
		$num = ($num + 2.28) * 2.612555;
		$num = explode('.', $num)[1];
		$str = substr($num, 0, $num % 6);
		$str_3 = base_convert($str, 10, 32);

		$return_string = $str_2 . '_' . $str_1 . '_' . $str_3;

		return $return_string;
	}


}

