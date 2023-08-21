<?php
namespace App\Controllers;

use App\Config\BaseController;
use App\Config\MariaDBCon;
use App\Config\ClickhouseDBCon;

class Migrations extends BaseController {

    use MariaDBCon, ClickhouseDBCon;

    public function Route(){

        $query = 
            "CREATE TABLE ".env('CLICKHOUSE_DBNAME').".table "
            ."( `url` String, "
            ."`full_url` String, "
            ."`time_sec` Int64, "
            ."`time_min` Int64 ) "
            ."ENGINE = MergeTree "
            ."ORDER BY time_sec "
            ."SETTINGS index_granularity = 8192;";

        // $query = "INSERT INTO `".env('CLICKHOUSE_DBNAME')."`.`".env('DB_MAIN_TABLES')."` (url,full_url,time_sec,time_min) "
        // ."VALUES ('fd','gd',21,65);";

        $clickhouse_data = $this->ClickhouseDBSendHTTPQuery($query);

        $pdo = $this->MariaDBInitConnection();
        $query = "CREATE TABLE `".env('DB_MAIN_TABLES')."` ("
           ."`url` varchar(100) NOT NULL,"
           ."`full_url` varchar(127) NOT NULL,"
           ."`time_sec` bigint(20) unsigned NOT NULL,"
           ."`time_min` bigint(20) unsigned NOT NULL, "
           ."`count` smallint(6) DEFAULT 0 NOT NULL "
          .") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        $maria_data = $this->MariaDBSendQuery( $pdo, $query);

        $obj = (object) [];
        $obj -> ok = true;
        $obj -> clickhouse_data = $clickhouse_data;
        $obj -> maria_data = $maria_data;
        $obj -> msg = "Migration completed";
 
        $this->RespOk_obj($obj);

        return true;
    }

}