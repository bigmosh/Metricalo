<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class CardPayDto
{
    #[Assert\NotBlank]
    #[Assert\Positive(message: "Amount must be a positive value.")]
    public float $amount;

    #[Assert\NotBlank]
    #[Assert\Currency(message: "Please provide a valid currency.")]
    public string $currency;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 13,
        max: 19,
        minMessage: "Card number must be at least {{ limit }} digits long",
        maxMessage: "Card number cannot be longer than {{ limit }} digits"
    )]
    public string $cardNumber;

    #[Assert\NotBlank]
    #[Assert\Range(
        min: 2024,
        max: 2050,
        notInRangeMessage: "The card expiration year must be between {{ min }} and {{ max }}"
    )]
    public string $cardExpYear;

    #[Assert\NotBlank]
    #[Assert\Range(
        min: 01,
        max: 12,
        notInRangeMessage: "The card expiration month must be between {{ min }} and {{ max }}"
    )]
    public string $cardExpMonth;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 4,
        exactMessage: "The CVV must be exactly {{ limit }} digits long"
    )]
    public string $cardCvv;
}
