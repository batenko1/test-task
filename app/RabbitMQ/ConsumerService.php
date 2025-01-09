<?php

namespace App\RabbitMQ;

use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class ConsumerService
{
    private AMQPStreamConnection $connection;
    private AbstractChannel|AMQPChannel $channel;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            config('rabbitmq.host'),
            config('rabbitmq.port'),
            config('rabbitmq.user'),
            config('rabbitmq.password')
        );

        $this->channel = $this->connection->channel();
    }

    public function consume(string $queue, callable $callback): void
    {
        $this->channel->queue_declare($queue, false, true, false, false);

        echo "Listening to queue: {$queue}\n";

        $this->channel->basic_consume(
            $queue,
            '',
            false,
            true,
            false,
            false,
            function (AMQPMessage $message) use ($callback) {
                $callback($message);
            }
        );

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    /**
     * @throws \Exception
     */
    public function close(): void
    {
        $this->channel->close();
        $this->connection->close();
    }
}
