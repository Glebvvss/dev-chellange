<?php

namespace App\Libs\Duplicates;

use Illuminate\Support\Str;
use InvalidArgumentException;

class DuplicatesOf
{
    private Text  $text;
    private array $texts;
    private float $expUnique;

    public function __construct(Text $text, array $texts, float $expUnique)
    {
        if ($expUnique > 100) {
            throw new InvalidArgumentException('Excepted unique percent parameter cannot be greather then 100');
        }

        $this->text      = $text;
        $this->texts     = $texts;
        $this->expUnique = $expUnique;
    }

    public function array(): array
    {
        return array_filter($this->texts, function($text) {
            $actUnique = UniquePercent::new(
                Matrix::new($this->text->content()),
                Matrix::new($text->content())
            );
            return $actUnique >= $this->expUnique;
        });
    }
}
