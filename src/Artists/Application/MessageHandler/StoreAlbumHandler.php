<?php

declare(strict_types=1);

namespace App\Artists\Application\MessageHandler;

use App\Artists\Application\Message\ManageAlbum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class StoreAlbumHandler
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(ManageAlbum $manageAlbum)
    {
        $this->entityManager->persist($manageAlbum->album);
        $this->entityManager->flush();

    }
}
