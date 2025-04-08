<?php

namespace App\Controller;

use App\Requests\PriceCalculationRequest;
use App\Services\PriceCalculatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/calculate-price', methods: ['POST'])]
    public function calculatePrice(
        PriceCalculationRequest $request,
        PriceCalculatorService $service
    ) {
        return new JsonResponse(['price' => $service->calculatePrice($request->productId, $request->taxNumber, $request->couponCode)]);
    }
}