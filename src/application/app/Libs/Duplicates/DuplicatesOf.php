<?php

namespace App\Libs\Duplicates;

use InvalidArgumentException;

class DuplicatesOf
{
    private Text   $text;
    private array  $texts;
    private float  $expUnique;
    private ?array $duplicates = null;

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
        if (is_array($this->duplicates)) return $this->duplicates;
        return $this->duplicates = array_filter($this->texts, function($text) {
            $actUnique = UniquePercent::between(
                $this->text->content(),
                $text->content()
            );
            return $actUnique < $this->expUnique;
        });
    }

    public function exists(): bool
    {
        return count($this->array()) > 0;
    }
}