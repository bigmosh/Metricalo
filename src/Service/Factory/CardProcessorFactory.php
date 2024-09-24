<?php
namespace App\Service\Factory;

use InvalidArgumentException;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

class CardProcessorFactory
{

    public function __construct(
        #[AutowireIterator('card_payment_providers')]
        private iterable $cardPaymentProviders
    ) {
    }

    public function getProvider(string $providerName)
    {
        foreach ($this->cardPaymentProviders as $paymentProvider) {
            if ($paymentProvider->getProviderName() === $providerName) {
                return $paymentProvider;
            }
        }
        throw new InvalidArgumentException("Invalid system parameter: " . $providerName);

    }

}
