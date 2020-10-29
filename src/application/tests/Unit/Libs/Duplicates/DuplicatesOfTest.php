<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use InvalidArgumentException;
use App\Libs\Duplicates\Text;
use App\Libs\Duplicates\DuplicatesOf;

class DuplicatesOfTest extends TestCase
{
    public function test_common_withUniqueGreatherThenRestriction()
    {
        $this->expectException(InvalidArgumentException::class);
        new DuplicatesOf(new Text('World hello test cut'), [], 101);
    }

    public function test_arrayMethod_withSameText()
    {
        $texts = [new Text('Hello world')];
        $duplicates = new DuplicatesOf(new Text('Hello world'), $texts, 100);
        $this->assertEquals($duplicates->array(), $texts);
    }

    public function test_arrayMethod_withSameTextWithCaseSensitive()
    {
        $texts = [new Text('Hello world')];
        $duplicates = new DuplicatesOf(new Text('HELLO WORLD'), $texts, 100);
        $this->assertEquals($duplicates->array(), $texts);
    }

    public function test_arrayMethod_withSameTextWithNoLetterSymbols()
    {
        $texts = [new Text('Hello world')];
        $duplicates = new DuplicatesOf(new Text('Hello world!!!'), $texts, 100);
        $this->assertEquals($duplicates->array(), $texts);
    }

    public function test_arrayMethod_withSameTextWithSpacesAtSides()
    {
        $texts = [new Text('Hello world')];
        $duplicates = new DuplicatesOf(new Text(' Hello world '), $texts, 100);
        $this->assertEquals($duplicates->array(), $texts);
    }

    public function test_arrayMethod_withReversedText()
    {
        $texts = [new Text('Hello world')];
        $duplicates = new DuplicatesOf(new Text('World hello'), $texts, 100);
        $this->assertEquals($duplicates->array(), $texts);
    }

    public function test_arrayMethod_withUniqueGreatherThenNeeded()
    {
        $texts = [new Text('Hello world')];
        $duplicates = new DuplicatesOf(new Text('World hello dear'), $texts, 50);
        $this->assertEquals($duplicates->array(), $texts);
    }

    public function test_arrayMethod_withUniqueEqualsToNeeded()
    {
        $texts = [new Text('Hello world')];
        $duplicates = new DuplicatesOf(new Text('World hello dear friends'), $texts, 50);
        $this->assertEquals($duplicates->array(), $texts);
    }

    public function test_arrayMethod_withUniqueLessThenNeeded()
    {
        $texts = [new Text('Hello world')];
        $duplicates = new DuplicatesOf(new Text('World hello test cut'), $texts, 90);
        $this->assertEquals($duplicates->array(), []);
    }
}
