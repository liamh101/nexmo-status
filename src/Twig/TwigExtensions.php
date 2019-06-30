<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigExtensions extends AbstractExtension
{

    public function getFilters(): array
    {
        return [
            new TwigFilter('sortByTimestamp', [$this, 'sortByTimestamp']),
        ];
    }

    public function sortByTimestamp($events): bool
    {
        return usort($events, 'dateSort');
    }

    private function dateSort($a, $b): int
    {
        return strtotime($a) - strtotime($b);
    }
}