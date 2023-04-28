<?php

declare(strict_types=1);

namespace App\Artists\Application\MessageHandler;

use App\Artists\Application\Message\ManageAlbum;
use App\Artists\Domain\Entity\Album;
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
        $album = new Album;
        $album->setName($manageAlbum->album->getName());
        $album->setArtist($manageAlbum->album->getArtist());

        $this->entityManager->persist($album);
        $this->entityManager->flush();

    }
}
