<?php

namespace App\Config;

trait Request
{
   public static function GetRequest(){
		$requestUrl = $_SERVER['REQUEST_URI'];
		$requestUrl = htmlspecialchars($requestUrl);

		$reqUrl = mb_stristr($requestUrl, '?', true);
		if( !$reqUrl )
			 $reqUrl = $requestUrl;
			 
		$arrUrl = explode("/", $reqUrl);
		return $arrUrl;
	}

}