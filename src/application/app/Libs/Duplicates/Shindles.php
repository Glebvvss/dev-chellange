<?php

namespace App\Libs\Duplicates;

use Illuminate\Support\Str;

class Shindles
{
    public static function create(string $text, int $size = 3): array
    {
        $words = Str::of(preg_replace('/[^a-z 0-9]/ui', '', $text))
                    ->trim()
                    ->lower()
                    ->explode(' ')
                    ->reject(fn($word) => strlen($word) < 3)
                    ->values()
                    ->toArray();

        $shingles = [];
        for ($position = 0; $position < self::lastShindelNumber($words, $size); $position++) {
            $shingle = '';

            for ($j = 0; $j < $size; $j++) {
                if (empty($shingle)) {
                    $shingle .= $words[$position + $j];
                } else {
                    $shingle .= ' ' . $words[$position + $j];
                }
            }

            $shingles[] = md5(trim($shingle));
        }

        return $shingles;
    }

    private static function lastShindelNumber(array $words, int $size): int
    {
        $number = count($words) - $size + 1;
        return $number > 0 ? $number : 1;
    }
}