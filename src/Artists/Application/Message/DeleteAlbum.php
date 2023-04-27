<?php

namespace App\Artists\Application\Message;

use App\Artists\Infrastructure\Symfony\Model\Album;
use App\Artists\Domain\Entity\Album as DomainAlbum;

final class DeleteAlbum
{
    public function __construct(public Album|DomainAlbum $album)
    {
    }
}
