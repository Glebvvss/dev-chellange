<?php

namespace App\Entities;

use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="articles")
 */
class Article
{
    private const EMPTY_CONTENT_ERR_MSG = 'Content of article must not be empty';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $content;

    public function __construct(string $content)
    {
        if (empty($content)) {
            throw new InvalidArgumentException(static::EMPTY_CONTENT_ERR_MSG);
        }

        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}