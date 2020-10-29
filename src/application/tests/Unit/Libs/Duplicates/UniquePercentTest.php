<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Libs\Duplicates\Matrix;
use App\Libs\Duplicates\UniquePercent;

class UniquePercentTest extends TestCase
{
    /**
     * @dataProvider forCreatingUniquePercentDataProvider
     */
    public function test_new_creatingUniquePercent(
        string $origText, 
        string $copyText, 
        float  $uniquePercent
    )
    {
        $this->assertEquals(
            UniquePercent::new(
                Matrix::new($origText),
                Matrix::new($copyText)
            ),
            $uniquePercent
        );
    }

    public function forCreatingUniquePercentDataProvider()
    {
        return [
            'empty' => [
                'origText'      => '',
                'copyText'      => '',
                'uniquePercent' => 100
            ],
            'same text' => [
                'origText'      => 'Hello world',
                'copyText'      => 'Hello world',
                'uniquePercent' => 100
            ],
            'same text with case sensitive' => [
                'origText'      => 'Hello world',
                'copyText'      => 'HELLO WORLD',
                'uniquePercent' => 100
            ],
            'same text with non-letter and non-numeric symbols' => [
                'origText'      => 'Hello world',
                'copyText'      => 'Hello world!!!!',
                'uniquePercent' => 100
            ],
            'same reversed text' => [
                'origText'      => 'Hello world',
                'copyText'      => 'World hello',
                'uniquePercent' => 100
            ],
            'full defferent texts' => [
                'origText'      => 'Hello world',
                'copyText'      => 'Lorem ipsum',
                'uniquePercent' => 0
            ],
            'defferent texts with common words' => [
                'origText'      => 'Hello world',
                'copyText'      => 'Hello my dear world',
                'uniquePercent' => 50
            ],
        ];
    }
}