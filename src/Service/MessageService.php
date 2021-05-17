<?php

namespace App\Service;

use App\Rabbit\MessagingProducer;
use Faker\Factory;
use Symfony\Component\HttpFoundation\JsonResponse;

class MessageService
{
    private $messagingProducer;

    public function __construct(MessagingProducer $messagingProducer)
    {
        $this->messagingProducer = $messagingProducer;
    }

    public function createMessage(int $numberOfUsers): JsonResponse
    {
        $faker = Factory::create();

        for ($i = 0; $i < $numberOfUsers; ++$i) {
            $message = json_encode([
                'sender' => $faker->companyEmail,
                'receiver' => $faker->email,
                'message' => $faker->text,
            ]);

            $this->messagingProducer->publish($message);
        }

        return new JsonResponse(['status' => 'Sent!']);
    }
}
