<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Libs\Duplicates\UniquePercent;

class UniquePercentTest extends TestCase
{
    /**
     * @dataProvider forCreatingUniquePercentDataProvider
     */
    public function test_between_creatingUniquePercent(
        string $origText, 
        string $copyText, 
        float  $uniquePercent
    )
    {
        $this->assertEquals(
            UniquePercent::between($origText, $copyText),
            $uniquePercent
        );
    }

    public function forCreatingUniquePercentDataProvider()
    {
        return [
            'empty' => [
                'origText'      => '',
                'copyText'      => '',
                'uniquePercent' => 0
            ],
            'same text' => [
                'origText'      => 'Hello world',
                'copyText'      => 'Hello world',
                'uniquePercent' => 0
            ],
            'same text with case sensitive' => [
                'origText'      => 'Hello world',
                'copyText'      => 'HELLO WORLD',
                'uniquePercent' => 0
            ],
            'same text with inserted short words' => [
                'origText'      => 'world',
                'copyText'      => 'a world',
                'uniquePercent' => 0
            ],
            'same text with non-letter and non-numeric symbols' => [
                'origText'      => 'Hello world',
                'copyText'      => 'Hello world!!!!',
                'uniquePercent' => 0
            ],
            'same reversed text' => [
                'origText'      => 'Hello world',
                'copyText'      => 'World hello',
                'uniquePercent' => 0
            ],
            'full defferent texts' => [
                'origText'      => 'Hello world',
                'copyText'      => 'Lorem ipsum',
                'uniquePercent' => 100
            ],
            'defferent texts with common words with 3 shindle size comparison and short word' => [
                'origText'      => 'Hello world',
                'copyText'      => 'Hello my dear world',
                'uniquePercent' => 33.33
            ],
            'same text longer then 20 symbols' => [
                'origText'      => 'World hello dear friends',
                'copyText'      => 'World hello dear friends',
                'uniquePercent' => 0
            ],
        ];
    }
}