<?php
namespace App\Config;


class Router extends RouterParent{

    public function CheckRoutes(){

        $arrUrl = $this->GetRequest();

        if( !isset($arrUrl[1]) || $arrUrl[1] === "" ){
            $this->ViewMainPage();
        }

        $this->ViewRoute($arrUrl[1]);

        return true;
    }

}