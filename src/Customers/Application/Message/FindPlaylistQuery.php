<?php

declare(strict_types=1);

namespace App\Customers\Application\Message;

use App\Customers\Domain\Entity\User;

class FindPlaylistQuery
{
    public function __construct(public readonly User $user)
    {
    }
}
