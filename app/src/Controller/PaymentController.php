<?php

namespace App\Controller;

use App\Requests\PriceCalculationRequest;
use App\Requests\PurchaseRequest;
use App\Services\PriceCalculatorService;
use App\Services\PurchaseService;
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

    #[Route('/purchase', methods: ['POST'])]
    public function purchase(
        PurchaseRequest $request,
        PriceCalculatorService $calculatorService,
        PurchaseService $purchaseService
    ) {
        $price = $calculatorService->calculatePrice($request->productId, $request->taxNumber, $request->couponCode);
        $result = $purchaseService->purchase($price,$request->paymentProcessor);
        return new JsonResponse(['result' => $result]);
    }
}