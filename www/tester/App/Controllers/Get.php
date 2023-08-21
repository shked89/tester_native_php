<?php
namespace App\Controllers;

use App\Config\BaseController;
use App\Services\URLsArray;
use App\Config\Request;

class Get extends BaseController {

    use URLsArray, Request;

    public function Route(){
 
        $url = $this->GetRequest();
        if( !isset($url[2]) )
            $this->RespErr_str("url_isnt_full", 400);
        $url = 'get/'.$url[2];

        $url_data = $this->GetArrayItem($url);
        if( $url_data === false )
            $this->RespErr_str("url_data_is_empty", 400);

        $this->RespOk_str($url_data);


        return true;
    }

}