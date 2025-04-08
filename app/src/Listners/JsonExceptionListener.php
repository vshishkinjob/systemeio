<?php

namespace App\Listners;

use App\Exceptions\InvalidDtoArguments;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class JsonExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if ($exception instanceof InvalidDtoArguments) {
            $response = new JsonResponse();
            if (!empty($exception->getErrors())) {
                $response->setData(['errors' => $exception->getErrors()]);
            } else {
                $response->setData(['error' => $exception->getMessage()]);
            }
            $response->setStatusCode(400);
            $event->setResponse($response);
        } else {
            $statusCode = $exception instanceof HttpExceptionInterface
                ? $exception->getStatusCode()
                : 500;
            $errorMessage = $exception->getMessage();
            $response = new JsonResponse(
                [
                    'status' => $statusCode,
                    'error' => $errorMessage,
                ],
                $statusCode
            );
        }
        $response->headers->set('Content-Type', 'application/json');
        $event->setResponse($response);
    }
}