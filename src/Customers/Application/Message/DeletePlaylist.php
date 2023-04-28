<?php

namespace App\Customers\Application\Message;

final class DeletePlaylist
{
    public function __construct(public string $id)
    {
    }
}
