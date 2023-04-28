<?php

declare(strict_types=1);

namespace App\Artists\Application\MessageHandler;

use App\Artists\Application\Message\DeleteAlbum;
use Doctrine\ORM\EntityManagerInterface;
use App\Artists\Domain\Repository\AlbumRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeleteAlbumHandler
{
    public function __construct(private EntityManagerInterface $entityManager, private readonly AlbumRepository $albumRepository)
    {
    }

    public function __invoke(DeleteAlbum $deleteAlbum)
    {
        $album = $this->albumRepository->findOneBy(['id' => $deleteAlbum->id]);
        $this->albumRepository->remove($album, true);
    }
}
