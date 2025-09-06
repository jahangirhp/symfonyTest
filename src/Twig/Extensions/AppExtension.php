<?php
// src/Twig/AppExtension.php
namespace App\Twig\Extensions;

use Twig\Attribute\AsTwigFilter;

class AppExtension
{
    #[AsTwigFilter('price')]
    public function formatPrice(float $number, int $decimals = 0, string $decPoint = '.', string $thousandsSep = ','): string
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$'.$price;

        return $price;
    }
}
