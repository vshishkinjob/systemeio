<?php

namespace App\Listners;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Validator\Constraints\Json;


class JsonRequestTransformerListener
{
    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $content = $request->getContent();
        if (empty($content)) {
            return;
        }
        $response = new JsonResponse();
        if (!$this->isJsonRequest($request)) {
            $response = $response->setData(['error' => 'Only JSON requests are allowed.']);
            $response->setStatusCode(Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
            $event->setResponse($response);
            return;
        }
        if (!$this->transformJsonBody($request)) {
            $response = $response->setData(['error' => 'Unable to parse request.']);
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $event->setResponse($response);
        }
    }

    private function isJsonRequest(Request $request)
    {
        return 'json' === $request->getContentTypeFormat();
    }

    private function transformJsonBody(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }
        if ($data === null) {
            return true;
        }
        $request->request->replace($data);
        return true;
    }
}