<?php

declare(strict_types=1);

namespace App\Customers\Application\MessageHandler;

use App\Customers\Application\Message\ManagePlaylist;
use App\Customers\Domain\Entity\Playlist;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class StorePlaylistHandler
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(ManagePlaylist $manageplaylist)
    {
        $playlist = new Playlist;
        $playlist->setName($manageplaylist->playlist->getName());
        $playlist->setUser($manageplaylist->playlist->getUser());

        $this->entityManager->persist($playlist);
        $this->entityManager->flush();

    }
}
