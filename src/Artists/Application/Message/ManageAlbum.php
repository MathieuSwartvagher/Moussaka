<?php

namespace App\Artists\Application\Message;

use App\Artists\Infrastructure\Symfony\Model\Album;

final class ManageAlbum
{
    public function __construct(public Album $album)
    {
    }
}
