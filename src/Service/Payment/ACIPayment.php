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
    private $baseUrl;
    private $logger;
    private $entityId;

    public function __construct(HttpClientInterface $httpClient, LoggerInterface $logger, string $aciApiKey, string $aciBaseUrl, string $entityId)
    {
        $this->httpClient = $httpClient;
        $this->aciApiKey = $aciApiKey;
        $this->logger = $logger;
        $this->baseUrl = $aciBaseUrl;
        $this->entityId = $entityId;
    }
    public function getProviderName(): string
    {
        return 'aci';
    }

    public function chargeCard(CardPaymentRequest $cardPaymentRequest): CardPaymentResponse
    {
        $response = $this->httpClient->request('POST', $this->baseUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->aciApiKey,
            ],
            'body' => http_build_query([
                'entityId' => $this->entityId,
                'amount' => $cardPaymentRequest->amount,
                'currency' => $cardPaymentRequest->currency,
                'paymentBrand' => 'VISA', // this is hardcoded since we don't have a bin checker
                'paymentType' => 'DB',
                'card.number' => $cardPaymentRequest->cardNumber,
                'card.holder' => 'Jane Jones',
                'card.expiryMonth' => $cardPaymentRequest->cardMonth,
                'card.expiryYear' => $cardPaymentRequest->cardYear,
                'card.cvv' => $cardPaymentRequest->cVV,
            ]),
            'verify_peer' => false,
        ]);

        $result = json_decode($response->getContent(false), true);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Error: ' . $result['result']['description']);
        }

        return new CardPaymentResponse(
            $result['id'],
            $result['timestamp'],
            $result['card']['bin'],
            $result['currency'],
            $result['amount'],
        );
    }
}
