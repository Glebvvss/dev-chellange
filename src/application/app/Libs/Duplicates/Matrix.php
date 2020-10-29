<?php

namespace App\Libs\Duplicates;

use Illuminate\Support\Str;

class Matrix
{
    public static function new(string $text): array
    {
        $words = array_filter(
            Str::of(preg_replace('/[^a-z 0-9]/ui', '', $text))
                ->trim()
                ->lower()
                ->explode(' ')
                ->toArray(), 
            fn($word) => strlen($word) > 0
        );

        $matrix = [];
        foreach($words as $word) {
            if (empty($matrix[$word])) {
                $matrix[$word] = 1;
            } else {
                $matrix[$word] += 1;
            }
        }
        return $matrix;
    }
}