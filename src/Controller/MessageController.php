<?php

namespace App\Controller;

use App\Service\MessageService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MessageController
{
    private $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * @Route("/send-message/{numberOfMessages}", name="send_message", methods={"GET"})
     * @throws \Exception
     */
    public function createMessages($numberOfMessages): JsonResponse
    {
        try {
            $this->messageService->createMessage($numberOfMessages);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

        return new JsonResponse(['status' => 'Sent!']);
    }
}