<?php

namespace App\Kafka;

use Jobcloud\Kafka\Exception\KafkaProducerTransactionAbortException;
use Jobcloud\Kafka\Exception\KafkaProducerTransactionFatalException;
use Jobcloud\Kafka\Exception\KafkaProducerTransactionRetryException;
use Jobcloud\Kafka\Message\KafkaProducerMessage;
use Jobcloud\Kafka\Producer\KafkaProducerBuilder;
use Jobcloud\Kafka\Producer\KafkaProducerInterface;


class ProducerService
{
    private KafkaProducerInterface $producer;

    public function __construct()
    {
        $this->producer = KafkaProducerBuilder::create()
            ->withAdditionalBroker(config('kafka.brokers'))
            ->build();
    }

    public function sendMessage(string $message): void
    {


        $producer = KafkaProducerBuilder::create()
            ->withAdditionalBroker('kafka:9092')
            ->build();

        $message = KafkaProducerMessage::create('my-topic', 0)
            ->withBody('test'.time());

        try {
            $producer->produce($message);

        } catch (KafkaProducerTransactionRetryException $e) {
            dd($e->getMessage());
        } catch (KafkaProducerTransactionAbortException $e) {
            dd($e->getMessage());

        } catch (KafkaProducerTransactionFatalException $e) {
            dd($e->getMessage());

        }

        $result = $producer->flush(1000);

        dd('sended', $result);

    }
}
