<?php
namespace App\Config;

use PDO;
use PDOException;

trait MariaDBCon {

	public static function MariaDBInitConnection(){

		$host     = env('MARIADB_HOST');
		$port     = env('MARIADB_PORT');
		$dbname   = env('MARIADB_DBNAME');
		$username = env('MARIADB_USER');
		$password = env('MARIADB_PASS');

		try {
			$pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// echo "Подключение успешно установлено!";
		} catch (PDOException $e) {
			// echo "Ошибка подключения: " . $e->getMessage();
			return false;
		}

		return $pdo;
	}

	public static function MariaDBSendQuery( &$pdo, $query ){
		
		try {
			$data = $pdo->query($query);
			$data = $data->fetchAll(PDO::FETCH_ASSOC);
		} catch (\Throwable $th) {
			$data = false;
		}

		return $data;
	}

}