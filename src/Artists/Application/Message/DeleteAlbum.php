<?php

namespace App\Artists\Application\Message;

final class DeleteAlbum
{
    public function __construct(public string $id)
    {
    }
}
