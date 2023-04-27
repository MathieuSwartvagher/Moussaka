<?php

declare(strict_types=1);

namespace App\Artists\Application\Message;

use Doctrine\Common\Collections\Collection;

class FindAlbumQuery
{
    public function __construct(public readonly Collection $artists)
    {
    }
}
