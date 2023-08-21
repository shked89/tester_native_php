<?php
namespace App\Controllers;

use App\Config\BaseController;
use App\Config\RabbitCon;
use App\Services\URLsArray;

class IntiRabbit extends BaseController {

    use RabbitCon, URLsArray;

	public $queve_name = 'urls_queue';

    public function Route(){

        $this->queve_name = env('RABBIT_QUEVE_NAME');

        $urls_array = $this->GetAllURLKeys();
        $urls_length_array = count($urls_array);

        $connection = $this->RabbitAMQPInitRoutes();
        $channel = $connection->channel();
        $this->RabbitAMQPQueueAnnouncement( $channel, $this->queve_name );

        //Очистить прошлую очередь
        // $channel->queue_purge( $this->queve_name );

        for ($i=0; $i < $urls_length_array; $i++) { 

            $secPassed = time();
            $minPassed = (int) ( $secPassed / 60 );
            $dataToSend = [
                'url' => $urls_array[$i],
                'full_url' => env('APP_URL').'/'.$urls_array[$i], 
                'time_sec' => $secPassed, 
                'time_min' => $minPassed,

            ];
    
            $this->RabbitAMQPQueueSendMsg( $channel, $this->queve_name, $dataToSend );

            // sleep( rand(4, 6) );
            sleep( rand(5, 30) );
        }

        $this->RabbitAMQPClosing( $connection, $channel );

 
        $this->RespOk_str(" init ");

        return true;
    }

}