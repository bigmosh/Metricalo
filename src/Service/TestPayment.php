<?php
namespace App\Service;

use App\Service\Adapter\CardPaymentRequest;
use App\Service\Adapter\CardPaymentResponse;
use App\Service\Adapter\ICardProcessorAdapter;

class TestPayment implements ICardProcessorAdapter{
  public function pay(CardPaymentRequest $cardPaymentRequest): CardPaymentResponse {
    return new CardPaymentResponse(
      1,
      '2024-11-1',
      '123324',
      'GHS',
      200
    );
  }
}