<?php
namespace App\Config;


class RouterParent {

	use Responses, Request;

	public function ViewMainPage(){
		$obj = (object) [];
		$obj->ok = true;
		$obj->msg = "Hello! There is a main page!";

		self::RespOk_obj($obj);
	}

	public function ViewRoute($path){

		$classPath = 'App\Controllers\\'.$path;

		if (class_exists($classPath)) {
			$class = new $classPath();

			$methodName = 'Route';

			if (method_exists($class, $methodName)) {
				call_user_func([$class, $methodName]);
			} else {
				self::RespErr_str("This method '$methodName' does not exist", 404);
			}
		} else {
			self::RespErr_str("This class '$classPath' does not exist", 404);
		}

		return true;
	}

}