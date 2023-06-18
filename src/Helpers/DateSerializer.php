<?php

namespace App\Helpers;

use DateTimeImmutable;

class DateSerializer
{
    public function normalizerDateCallback()
    {
       return function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
            return $innerObject instanceof DateTimeImmutable ? $innerObject->format(DateTimeImmutable::ISO8601) : '';
        };
    }
}