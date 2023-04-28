<?php

declare(strict_types=1);

namespace App\Customers\Application\MessageHandler;

use App\Customers\Application\Message\DeletePlaylist;
use Doctrine\ORM\EntityManagerInterface;
use App\Customers\Domain\Repository\PlaylistRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeletePlaylistHandler
{
    public function __construct(private EntityManagerInterface $entityManager, private readonly PlaylistRepository $playlistRepository)
    {
    }

    public function __invoke(DeletePlaylist $deletePlaylist)
    {
        $album = $this->playlistRepository->findOneBy(['id' => $deletePlaylist->id]);
        $this->playlistRepository->remove($album, true);
    }
}
