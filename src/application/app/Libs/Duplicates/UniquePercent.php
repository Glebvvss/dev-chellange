<?php

namespace App\Libs\Duplicates;

class UniquePercent
{
    public static function new(array $origMatrix, array $copyMatrix): float
    {
        $words = array_keys($origMatrix + $copyMatrix);

        if (empty($words)) {
            return 100;
        }

        $comparison = 0;
        foreach($words as $word) {
            if (!isset($origMatrix[$word]) || !isset($copyMatrix[$word])) {
                continue;
            }

            if ($origMatrix[$word] === $copyMatrix[$word]) {
                $comparison++;
            }
        }

        return $comparison / count($words) * 100;
    }
}