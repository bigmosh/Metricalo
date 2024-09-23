<?php
namespace App\Controller;

use App\Dto\CardPayDto;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PaymentController extends AbstractController
{
    #[Route('/app/pay/{provider}', name: 'cardpay',  methods: ['POST'])]
    public function processCardPayment(#[MapRequestPayload()] CardPayDto $cardPayDto, ValidatorInterface $validator, 
     string $provider): JsonResponse
    {
       return $this->json([
          'status' => $provider
       ]);
    }
}