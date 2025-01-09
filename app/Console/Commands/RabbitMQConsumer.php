<?php

namespace App\Console\Commands;

use App\RabbitMQ\ConsumerService;
use Illuminate\Console\Command;

class RabbitMQConsumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:rabbit-m-q-consumer {queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    private ConsumerService $listener;

    public function __construct(ConsumerService $listener)
    {
        parent::__construct();
        $this->listener = $listener;
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $queue = $this->argument('queue');

        $this->info("Starting listener for queue: {$queue}");

        $this->listener->consume($queue, function ($message) {
            $this->info("Received message: {$message->body}");

            // Здесь можно добавить обработку сообщения
            // Например, обработка JSON
            // $data = json_decode($message->body, true);
        });

        $this->listener->close();
    }
}
