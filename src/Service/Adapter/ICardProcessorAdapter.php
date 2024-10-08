<?php
namespace App\Service\Adapter;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

class CardPaymentRequest
{
    public string $cardNumber;
    public string $cardMonth;
    public string $cardYear;
    public string $cVV;
    public string $currency;
    public string $amount;
    public function __construct($cardNumber, $cardMonth, $cardYear, $cVV, $currency, $amount)
    {
      $this->cardNumber = $cardNumber;
      $this->cardMonth = $cardMonth;
      $this->cardYear = $cardYear;
      $this->cVV = $cVV;
      $this->currency = $currency;
      $this->amount = $amount;
    }
}

class CardPaymentResponse
{
  public string $transactionId;
  public string $date;
  public string $cardBin;
  public string $currency;
  public string $amount;
  public function __construct($transactionId, $date, $cardBin, $currency, $amount)
  {
    $this->transactionId = $transactionId;
    $this->date = $date;
    $this->cardBin = $cardBin;
    $this->currency = $currency;
    $this->currency = $currency;
    $this->amount = $amount;
  }
}

#[AutoconfigureTag(name: 'card_payment_providers')]
interface ICardProcessorAdapter
{ 
    public function getProviderName(): string;
    public function chargeCard(CardPaymentRequest $cardPaymentObject): CardPaymentResponse;
}
