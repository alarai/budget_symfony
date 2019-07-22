<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class BudgetExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('pad', [$this, 'pad']),
        ];
    }

    public function pad($value, $pad_length, $pad_string = " ", $left)
    {
        return str_pad($value, $pad_length, $pad_string, $left?STR_PAD_LEFT:STR_PAD_RIGHT);
    }
}
