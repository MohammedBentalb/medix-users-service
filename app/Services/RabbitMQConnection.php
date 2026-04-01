<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQConnection {
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;

    public function __construct() {
        try {
            $this->connection = new AMQPStreamConnection(
                env('RABBITMQ_HOST', 'localhost'),
                env('RABBITMQ_PORT', 5672),
                env('RABBITMQ_USER', 'guest'),
                env('RABBITMQ_PASSWORD', 'guest'),
                env('RABBITMQ_VHOST', '/'),
            );
            $this->channel = $this->connection->channel();
            $this->channel->exchange_declare('users.events', 'topic', false, true, false);
        } catch (\Throwable $e) {
            Log::error('RabbitMQ connection failed', ['error' => $e->getMessage()]);
            throw new \RuntimeException('Failed to connect to RabbitMQ', 0, $e);
        }
    }

    public function channel(): AMQPChannel {
        return $this->channel;
    }
}