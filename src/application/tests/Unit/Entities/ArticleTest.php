<?php

namespace Tests\Unit\Entities;

use App\Entities\Article;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    const STUB_CONTENT_STRING = 'Hello world';

    public function test_common_withEmptyContent()
    {
        $this->expectException(InvalidArgumentException::class);
        new Article('');
    }

    public function test_common_withCorrectStringContent()
    {
        $article = new Article(self::STUB_CONTENT_STRING);
        $this->assertSame($article->getContent(), self::STUB_CONTENT_STRING);
    }
}