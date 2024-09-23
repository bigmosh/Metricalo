<?php
namespace App\Service\Factory;

use App\Service\Adapter\ICardProcessorAdapter;
use App\Service\TestPayment;
use InvalidArgumentException;

class CardProcessorFactory
{
    private static $providerMappings = [
        'test' => TestPayment::class
    ];

    public static function getProvider(string $provider): ICardProcessorAdapter
    {
        if (array_key_exists($provider, self::$providerMappings)) {
            $providerClass = self::$providerMappings[$provider];
            return new $providerClass();
        }

        throw new InvalidArgumentException("Invalid system parameter: " . $provider);
    }
}
