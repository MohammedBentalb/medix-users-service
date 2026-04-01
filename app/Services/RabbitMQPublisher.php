<?php

namespace App\Services;

use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQPublisher {
    public function __construct(private RabbitMQConnection $connection) {}

    public function publish(string $routingKey, array $payload){
        $message = new AMQPMessage(json_encode([
            ...$payload
        ]), [
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
            'content_type' => 'application/json',
        ]);

        $this->connection->channel()->basic_publish($message, 'users.events', $routingKey);
    }
}