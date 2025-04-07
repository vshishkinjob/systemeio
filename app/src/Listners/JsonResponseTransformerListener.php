<?php

namespace App\Listners;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class JsonResponseTransformerListener
{
    public function onKernelResponse(ResponseEvent $event)
    {
        $response = $event->getResponse();
        if (!$event->isMainRequest()) {
            return;
        }
        $content = $response->getContent();
        if ($this->isJson($content)) {
            return;
        }
        $jsonContent = json_encode([
            'status' => $response->getStatusCode(),
            'data' => $content,
        ]);
        $newResponse = new Response(
            $jsonContent,
            $response->getStatusCode(),
            ['Content-Type' => 'application/json']
        );
        $event->setResponse($newResponse);
    }

    private function isJson(string $string): bool
    {
        if (empty($string)) {
            return false;
        }
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}