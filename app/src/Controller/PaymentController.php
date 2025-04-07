<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController
{
    #[Route('/calculate-price', methods: ['POST'])]
    public function calculatePrice(
        Request $request
    )
    {
        return new Response('123');
    }
}