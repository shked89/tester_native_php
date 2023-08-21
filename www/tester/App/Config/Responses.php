<?php

namespace App\Config;

trait Responses
{
   public static function RespErr_str( $str, $code ){

      header("HTTP/1.0 ".$code);
      header('Content-Type: application/json');
      header('Access-Control-Allow-Origin: *');
      echo '{"ok":false, "msg":"'.$str.'"}';
      exit();
   }
   
   public static function RespErr_obj( &$obj, $code ){

      header("HTTP/1.0 ".$code);
      header('Content-Type: application/json');
      header('Access-Control-Allow-Origin: *');
      // echo '{"ok":false, "msg":"'.$str.'"}';
      echo json_encode($obj, JSON_UNESCAPED_UNICODE);
      exit();
   }

   public static function RespOk_obj( &$obj ){

      // $obj -> ok = true;
      header("HTTP/1.0 200");
      header('Content-Type: application/json');
      header('Access-Control-Allow-Origin: *');
      echo json_encode($obj, JSON_UNESCAPED_UNICODE);
      exit();
   }

   public static function RespOk_arr( &$arr ){

      header("HTTP/1.0 200");
      header('Content-Type: application/json');
      header('Access-Control-Allow-Origin: *');
      echo json_encode($arr, JSON_UNESCAPED_UNICODE);
      exit();
   }

   public static function RespOk_str( $str ){
      $obj = (object) [];
      $obj -> ok = true;
      $obj -> msg = $str;
      header("HTTP/1.0 200");
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/json');
      echo json_encode($obj, JSON_UNESCAPED_UNICODE);
      exit();
   }

}