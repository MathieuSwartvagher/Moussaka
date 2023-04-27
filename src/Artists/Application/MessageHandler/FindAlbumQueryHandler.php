<?php

declare(strict_types=1);

namespace App\Artists\Application\MessageHandler;

use App\Artists\Application\Message\FindAlbumQuery;
use App\Artists\Domain\Repository\AlbumRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Doctrine\Common\Collections\Criteria;


#[AsMessageHandler]
class FindAlbumQueryHandler
{
    public function __construct(private readonly AlbumRepository $albumRepository)
    {
    }

    public function __invoke(FindAlbumQuery $findAlbumQuery)
    {
        $criteria = Criteria::create()->where(Criteria::expr()->in('artist', $findAlbumQuery->artists->toArray()));
        $albums = $this->albumRepository->matching($criteria);
        return $albums;
    }
}