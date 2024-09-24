<?php
namespace App\Service\Payment;

use App\Service\Adapter\CardPaymentRequest;
use App\Service\Adapter\CardPaymentResponse;
use App\Service\Adapter\ICardProcessorAdapter;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Shift4Payment implements ICardProcessorAdapter
{

    private $httpClient;
    private $shift4ApiKey;
    private $baseUrl;
    private $logger;

    public function __construct(HttpClientInterface $httpClient, LoggerInterface $logger, string $shift4ApiKey, string $shift4BaseUrl)
    {
        $this->httpClient = $httpClient;
        $this->shift4ApiKey = $shift4ApiKey;
        $this->logger = $logger;
        $this->baseUrl = $shift4BaseUrl;
    }
    public function getProviderName(): string
    {
        return 'shift4';
    }

    public function chargeCard(CardPaymentRequest $cardPaymentRequest): CardPaymentResponse
    {
        $tokenResult = $this->createCardToken($cardPaymentRequest);
        $response = $this->httpClient->request('POST', $this->baseUrl.'/charges', [
            'auth_basic' => [$this->shift4ApiKey, ''],
            'body' => [
                'amount' => $cardPaymentRequest->amount,
                'currency' => $cardPaymentRequest->currency,
                'customerId' => 'cust_TuFxFtqIvcPFrbaVJjFMzJqa', // this is hardcoded
                'card' => $tokenResult['id'],
                'description' => 'new charge',
            ],
        ]);

        $result = json_decode($response->getContent(false), true);        

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Error: ' . $result['result']['description']);
        }

        return new CardPaymentResponse(
            $result['id'],
            date('Y-m-d h:m:i'),
            $result['card']['first6'],
            $result['currency'],
            $result['amount'],
        );
        return new CardPaymentResponse(
          1,
          '2024-11-1',
          '123324',
          'GHS',
          200
        );
    }

    public function createCardToken(CardPaymentRequest $cardPaymentRequest) {
        $response = $this->httpClient->request('POST', $this->baseUrl.'/tokens', [
          'auth_basic' => [$this->shift4ApiKey, ''],
          'body' => [
              'number' => $cardPaymentRequest->cardNumber,
              'expMonth' => $cardPaymentRequest->cardMonth,
              'expYear' => $cardPaymentRequest->cardYear,
              'cvc' => $cardPaymentRequest->cVV,
              'cardholderName' => 'John Doe',
          ],
      ]);

      $result = json_decode($response->getContent(false), true);

       if ($response->getStatusCode() !== 200) {
            throw new \Exception('Error: ' . $result['result']['description']);
       }

       return $result;
    }

}