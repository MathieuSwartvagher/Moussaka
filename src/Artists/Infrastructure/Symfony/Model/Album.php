<?php

namespace App\Artists\Infrastructure\Symfony\Model;

use App\Artists\Domain\Entity\Artist;

class Album
{
    public function __construct(
        public readonly string $name,
        public readonly Artist $artist,
    ) {}
}
