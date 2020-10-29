<?php

namespace App\Libs\Duplicates;

class Text
{
    private string $text;
    private array  $meta;

    public function __construct(string $text, array $meta = [])
    {
        $this->text = $text;
        $this->meta = $meta;
    }

    public function content(): string
    {
        return $this->text;
    }

    public function meta(): array
    {
        return $this->meta;
    }
}