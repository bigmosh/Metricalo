<?php
namespace App\Controller;

use App\Dto\CardPayDto;
use App\Service\Adapter\CardPaymentRequest;
use App\Service\Factory\CardProcessorFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class PaymentController extends AbstractController
{
    #[Route('/app/pay/{provider}', name: 'cardpay', methods: ['POST'])]
    public function processCardPayment(CardProcessorFactory $cardProcessorFactory, #[MapRequestPayload()] CardPayDto $cardPayDto,
        string $provider): JsonResponse {
        $provider = $cardProcessorFactory->getProvider($provider);

        $cardPaymentRequest = new CardPaymentRequest($cardPayDto->cardNumber, $cardPayDto->cardExpMonth, $cardPayDto->cardExpYear, $cardPayDto->cardCvv, $cardPayDto->currency, $cardPayDto->amount);

        $cardPaymentResponse = $provider->chargeCard($cardPaymentRequest);
        return $this->json($cardPaymentResponse);
    }
}
