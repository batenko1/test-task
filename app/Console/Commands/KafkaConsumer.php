<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Jobcloud\Kafka\Consumer\KafkaConsumerBuilder;
use Jobcloud\Kafka\Exception\KafkaConsumerConsumeException;
use Jobcloud\Kafka\Exception\KafkaConsumerEndOfPartitionException;
use Jobcloud\Kafka\Exception\KafkaConsumerTimeoutException;

class KafkaConsumer extends Command
{
    protected $signature = 'kafka:consume';
    protected $description = 'Consume messages from Kafka';

    public function handle()
    {
        $consumer = KafkaConsumerBuilder::create()
            ->withAdditionalBroker(config('kafka.brokers'))
            ->withConsumerGroup(config('kafka.group_id'))
            ->withAdditionalSubscription(config('kafka.topics.default'))
            ->build();

        $consumer->subscribe();

        while (true) {
            try {
                $message = $consumer->consume();

                $this->info($message->getBody());
                // your business logic
                $consumer->commit($message);
            } catch (KafkaConsumerTimeoutException $e) {
                $this->info('ошибка '. $e->getMessage());
                //no messages were read in a given time
            } catch (KafkaConsumerEndOfPartitionException $e) {
                $this->info('ошибка 2 '. $e->getMessage());

                //only occurs if enable.partition.eof is true (default: false)
            } catch (KafkaConsumerConsumeException $e) {
                $this->info($e->getMessage().config('kafka.topics.default'));

                // Failed
            }
        }

    }
}
