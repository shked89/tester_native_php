<?php
namespace App\Controllers;

use App\Config\BaseController;
use App\Config\RabbitCon;
use App\Services\URLsArray;

class GetRabbit extends BaseController {

    use RabbitCon, URLsArray;

	public $queve_name = 'urls_queue';

    public function Route(){

        $this->queve_name = env('RABBIT_QUEVE_NAME');

        $connection = $this->RabbitAMQPInitRoutes();
		$channel = $connection->channel();

		$this->RabbitAMQPQueueAnnouncement( $channel, $this->queve_name );

        $maxRuntime = time() + 3;
        $receivedMessages = 0;

        $msgs_array = [];
        
        while (time() <= $maxRuntime ) {
        
            $message = $channel->basic_get($this->queve_name);
        
            if ($message) {
                $channel->basic_ack($message->delivery_info['delivery_tag']);
                try {
                    $data = json_decode($message->body);
                } catch (\Throwable $th) {
                    $data = $message->body;
                }
                $msgs_array[] = $data;
                $receivedMessages++;
            }
            usleep(100000); 
        }

        $json_options = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES;

        file_put_contents( 
            __basepath__.DIRECTORY_SEPARATOR."data".DIRECTORY_SEPARATOR.'GetRabbitData.txt',
            json_encode( $msgs_array, $json_options )
        );


		$this->RabbitAMQPClosing( $connection, $channel );

        $obj = (object) [];
        $obj -> ok = true;
        $obj -> msgs_array = $msgs_array;
 
        $this->RespOk_obj($obj);

        return true;
    }

}