<?php

declare(strict_types=1);

namespace App\Artists\Application\MessageHandler;

use App\Artists\Application\Message\DeleteAlbum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeleteAlbumHandler
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(DeleteAlbum $manageAlbum)
    {

    }
}
