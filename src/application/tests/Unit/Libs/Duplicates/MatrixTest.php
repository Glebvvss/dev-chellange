<?php

namespace Tests\Unit\Libs\Duplicates;

use App\Libs\Duplicates\Matrix;
use PHPUnit\Framework\TestCase;

class MatrixTest extends TestCase
{
    /**
     * @dataProvider forMatrixDataProvider()
     */
    public function test_newStaticMethod_forCreatingMatrix(string $text, array $matrix)
    {
        $this->assertEquals(Matrix::new($text), $matrix);
    }

    public function forMatrixDataProvider()
    {
        return [
            [
                'text' => '', 
                'matrix' => []
            ],
            [
                'text' => 'Hello world', 
                'matrix' => [
                    'hello' => 1,
                    'world' => 1
                ]
            ],
            [
                'text' => 'Hello world, dear world', 
                'matrix' => [
                    'hello' => 1,
                    'world' => 2,
                    'dear'  => 1
                ]
            ]
        ];
    }
}