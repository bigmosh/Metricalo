<?php
namespace App\Controller;

use App\Dto\CardPayDto;
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
        $provider = $cardProcessorFactory::getProvider($provider);
        return $this->json([
            'status' => $provider,
        ]);
    }
}
