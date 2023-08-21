<?php
namespace App\Config;

use PDO;
use PDOException;
use Responses;

trait ClickhouseDBCon {

	public static function ClickhouseDBSendHTTPQuery($query){

		$host     = env('CLICKHOUSE_HOST');
		$port     = env('CLICKHOUSE_PORT');
		$database = env('CLICKHOUSE_DBNAME');
		$username = env('CLICKHOUSE_USER');
		$password = env('CLICKHOUSE_PASS');

		$clickhouseUrl = 'http://'.$host.':'.$port.'/';
		// $clickhouseUrl = 'http://localhost:8123/';

		// try {
			$ch = curl_init($clickhouseUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
			curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: text/plain']);

			$response = curl_exec($ch);

			// if( isset($response[1]) && $response[0] === "C" && $response[1] === "o")
			// 	$response = false;
			// else
			// 	if( $response === "")
			// 		$response = true;

			if ($response === false) {
				// echo 'Ошибка: ' . curl_error($ch);
				curl_close($ch);
				return false;
			} else {
				// echo 'Результат: ' . $response;
				curl_close($ch);
				return $response;
			}
	}

}