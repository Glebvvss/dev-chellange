<?php

namespace Tests\Unit;

use App\Libs\Duplicates\Shindles;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Str;

class ShindlesTest extends TestCase
{
    /**
     * @dataProvider createMethodDataProvider
     */
    public function test_create($text, $size, $expect)
    {
        $this->assertEquals(Shindles::create($text, $size), $expect);
    }

    public function createMethodDataProvider()
    {
        return [
            'uses 1 word shindle size' => [
                'text'   => 'Hello world',
                'size'   => 1,
                'expect' => [
                    md5('hello'), 
                    md5('world')
                ]
            ],
            'uses short words in text' => [
                'text'   => 'Hello my world',
                'size'   => 1,
                'expect' => [
                    md5('hello'), 
                    md5('world')
                ]
            ],
            'uses 3 shindle size' => [
                'text'   => 'Hello world, Lorem Ipsum',
                'size'   => 3,
                'expect' => [
                    md5('hello world lorem'), 
                    md5('world lorem ipsum')
                ]
            ],
            'uses 3 shindle size longer then text' => [
                'text'   => 'Hello world',
                'size'   => 4,
                'expect' => [
                    md5('hello world')
                ]
            ],
        ];
    }
}