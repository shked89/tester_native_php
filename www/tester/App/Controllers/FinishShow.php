<?php
namespace App\Controllers;

use App\Config\BaseController;
use App\Services\URLsArray;
use App\Config\Request;
use App\Config\MariaDBCon;

class FinishShow extends BaseController {

    use Request, MariaDBCon;

    public function Route(){

        $pdo = $this->MariaDBInitConnection();
 
        $query = "SELECT COUNT(*) AS row_count, time_min,"
            ." AVG(LENGTH(full_url)) AS avg_content_length,"
            ." MIN(time_sec) AS first_message_time,"
            ." MAX(time_sec) AS last_message_time"
            ." FROM `table` GROUP BY `time_min`;";
            
        $data = $this->MariaDBSendQuery( $pdo, $query );

        $obj = (object) [];
        $obj -> ok = true;
        $obj -> data = $data;

        $this -> RespOk_obj( $obj );
    }

}