<?php
namespace App\Config;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


trait RabbitCon {

	public static function RabbitAMQPInitRoutes(){
		$host  = env('RABBIT_HOST');
		$port  = env('RABBIT_PORT');
		$user  = env('RABBIT_USER');
		$pass  = env('RABBIT_PASS');
		$vhost = env('RABBIT_VHOST');

		$connection = new AMQPStreamConnection($host, $port, $user, $pass, $vhost);
		
		return $connection;
	}

	public static function RabbitAMQPQueueAnnouncement( &$channel, $name ){
		$channel->queue_declare( $name, false, true, false, false );
	}

	public static function RabbitAMQPClosing( &$connection, &$channel ){
		$channel->close();
		$connection->close();
	}

	public static function RabbitAMQPQueueSendMsg( $channel, $queve_name, $dataToSend ){
		$message = new AMQPMessage(json_encode($dataToSend));

        // Отправляем сообщение в очередь
        $channel->basic_publish($message, '', $queve_name);
	}

}