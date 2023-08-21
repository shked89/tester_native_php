<?php
namespace App\Controllers;

use App\Config\BaseController;
use App\Config\MariaDBCon;
use App\Services\URLsArray;

class UriGotRabbitToSqlDB extends BaseController {

    use MariaDBCon;
    use URLsArray;

    public function Route(){

        $file_path = __basepath__.DIRECTORY_SEPARATOR."data".DIRECTORY_SEPARATOR.'GetRabbitData.txt';
        $uri_array = [];

        if ( !file_exists( $file_path ) ) {
            $this->RespOk_obj( $uri_array );
        }
        $uri_array = file_get_contents( $file_path );
        unlink($file_path);

        try {
            $uri_array = json_decode( $uri_array );
        } catch (\Throwable $th) {
            $uri_array = [];
        }

        $pdo = $this->MariaDBInitConnection();

        $query = "DELETE FROM `".env('DB_MAIN_TABLES')."`;";
        $this->MariaDBSendQuery( $pdo, $query );

        foreach ($uri_array as &$key) {

            $count_symbols = strlen( $this->GetArrayItem( $key->url ) );

            usleep(1000);
            $query = 
                "INSERT INTO `".env('DB_MAIN_TABLES')."` (`url`, `full_url`, `time_sec`, `time_min`, `count`) VALUES "
                ."('".$key->url."','".$key->full_url."','".$key->time_sec."','".$key->time_min."','$count_symbols');";

            $this->MariaDBSendQuery( $pdo, $query );
        }

        $obj = (object) [];
        $obj -> uri_array = $uri_array;
 
        $this->RespOk_obj( $obj );

        return true;
    }

}