<?php

namespace App\Libs\Duplicates;

class UniquePercent
{
    public static function between(string $origText, string $copyText): float
    {
        $shindleSize = strlen(trim($origText)) < 20 || strlen(trim($copyText) < 20) ? 1 : 3;
        $shingle1 = Shindles::create($origText, $shindleSize);
        $shingle2 = Shindles::create($copyText, $shindleSize);

        if (count($shingle2) > count($shingle1)) {
            $shingle_tmp = $shingle1;
            $shingle1 = $shingle2;
            $shingle2 = $shingle_tmp;
        }

        if (empty($diff = array_diff($shingle1, $shingle2))) {
            return 0;
        }

        return round(count($diff) / count($shingle1) * 100, 2);
    }
}