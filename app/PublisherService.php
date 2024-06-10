<?php

namespace App;

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class PublisherService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        
    }

    public function cartPublish($message)
    {
        $connection = new AMQPStreamConnection(env('MQ_HOST'), env('MQ_PORT'), env('MQ_USER'), env('MQ_PASS'), env('MQ_VHOST'));
        $channel = $connection->channel();
        $channel->exchange_declare('buy_exchange', 'direct', false, false, false);
        $channel->queue_declare('buy_queue', false, false, false, false);
        $channel->queue_bind('buy_queue', 'buy_exchange', 'buy_exchange');
        $msg = new AMQPMessage($message);
        $channel->basic_publish($msg, 'buy_exchange', 'buy_exchange');
        echo " [x] Sent $message to buy_exchange / buy_queue.\n";
        $channel->close();
        $connection->close();
    }

    public function deleteCartPublish($message)
    {
        $connection = new AMQPStreamConnection(env('MQ_HOST'), env('MQ_PORT'), env('MQ_USER'), env('MQ_PASS'), env('MQ_VHOST'));
        $channel = $connection->channel();
        $channel->exchange_declare('delete_cart_exchange', 'direct', false, false, false);
        $channel->queue_declare('delete_cart_queue', false, false, false, false);
        $channel->queue_bind('delete_cart_queue', 'delete_cart_exchange', 'delete_cart_exchange');
        $msg = new AMQPMessage($message);
        $channel->basic_publish($msg, 'delete_cart_exchange', 'delete_cart_exchange');
        echo " [x] Sent $message to delete_cart_exchange / delete_cart_queue.\n";
        $channel->close();
        $connection->close();
    }
}
