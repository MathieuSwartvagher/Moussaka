<?php

namespace App\Customers\Application\Message;

use App\Customers\Infrastructure\Symfony\Model\Playlist;

final class ManagePlaylist  
{
    public function __construct(public Playlist $playlist)
    {
    }
}
