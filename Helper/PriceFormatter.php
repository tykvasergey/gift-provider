<?php
declare(strict_types=1);

namespace RealThanks\GiftProvider\Helper;

class PriceFormatter
{
    public static function format(float $price) : string
    {
        $fmt = new \NumberFormatter( 'de_DE', \NumberFormatter::CURRENCY );

        return $fmt->formatCurrency($price, "USD");
    }
}
