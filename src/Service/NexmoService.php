<?php

namespace App\Service;

use Nexmo\Client;
use Psr\Log\LoggerInterface;

class NexmoService
{
    /** @var Client */
    private $client;

    /** @var Logger */
    private $logger;

    public function __construct(Client $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    public function makeCall(string $message, string $receiverNumber = null)
    {
        $this->logger->info('Call being made', ['message' => $message]);

        if (!$receiverNumber) {
            $receiverNumber = $_ENV['DEFAULT_CALLER_NUMBER'];
        }

        $this->client->calls()->create([
            'to' => [[
                'type' => 'phone',
                'number' => $_ENV['DEFAULT_RECEIVER_NUMBER'],
            ]],
            'from' => [
                'type' => 'phone',
                'number' => $receiverNumber,
            ],
            'ncco' => [
                [
                    'action' => 'talk',
                    'text' => $message,
                ]
            ]
        ]);
    }

    public function sendSMS(string $message)
    {
        $this->logger->info('Text message being sent', ['message' => $message]);

        $this->client->message()->send([
            'to' => $_ENV['DEFAULT_RECEIVER_NUMBER'],
            'from' => '447418347739',
            'text' => $message
        ]);
    }

    public function newEvent(array $event)
    {
        $this->logger->info('Creating new event');

    }
}