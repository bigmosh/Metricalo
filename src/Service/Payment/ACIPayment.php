<?php
namespace App\Service\Payment;

use App\Service\Adapter\CardPaymentRequest;
use App\Service\Adapter\CardPaymentResponse;
use App\Service\Adapter\ICardProcessorAdapter;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ACIPayment implements ICardProcessorAdapter
{

    private $httpClient;
    private $aciApiKey;
    private $logger;
    public function __construct(HttpClientInterface $httpClient, string $aciApiKey, LoggerInterface $logger)
    {
        $this->httpClient = $httpClient;
        $this->aciApiKey = $aciApiKey;
        $this->logger = $logger;
    }
    public function getProviderName( ): string {
      return 'aci';
    }

    public function chargeCard(CardPaymentRequest $cardPaymentRequest): CardPaymentResponse
    {
        return new CardPaymentResponse(
            1,
            '2024-11-1',
            '123324',
            'GHS',
            200
        );
    }
}
