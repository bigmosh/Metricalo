<?php
namespace App\Service\Factory;

use InvalidArgumentException;

class CardProcessorFactory
{
    private static $providerMappings = [];

    public static function getProvider($provider)
    {
        if (array_key_exists($provider, self::$providerMappings)) {
            $providerClass = self::$providerMappings[$provider];
            return new $providerClass();
        }

        throw new InvalidArgumentException("Invalid system parameter: " . $provider);
    }
}
