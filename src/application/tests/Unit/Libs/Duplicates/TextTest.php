<?php

namespace Tests\Unit;

use App\Libs\Duplicates\Text;
use PHPUnit\Framework\TestCase;

class TextTest extends TestCase
{
    const STUB_TEXT_STRING = 'Hello world';
    const STUB_TEXT_META   = ['id' => 1];

    public function test_common_withoutMeta()
    {
        $text = new Text(self::STUB_TEXT_STRING);
        $this->assertSame(self::STUB_TEXT_STRING, $text->content());
        $this->assertSame([], $text->meta());
    }

    public function test_common_withMetadata()
    {
        $text = new Text(self::STUB_TEXT_STRING, self::STUB_TEXT_META);
        $this->assertSame(self::STUB_TEXT_STRING, $text->content());
        $this->assertEquals(self::STUB_TEXT_META, $text->meta());
    }
}