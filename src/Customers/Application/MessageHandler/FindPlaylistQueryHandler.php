<?php

declare(strict_types=1);

namespace App\Customers\Application\MessageHandler;

use App\Customers\Application\Message\FindPlaylistQuery;
use App\Customers\Domain\Repository\PlaylistRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;


#[AsMessageHandler]
class FindPlaylistQueryHandler
{
    public function __construct(private readonly PlaylistRepository $playlistRepository)
    {
    }

    public function __invoke(FindPlaylistQuery $findPlaylistQuery)
    {
        $playlists = $this->playlistRepository->findBy(['user' => $findPlaylistQuery->user]);

        return $playlists;
    }
}