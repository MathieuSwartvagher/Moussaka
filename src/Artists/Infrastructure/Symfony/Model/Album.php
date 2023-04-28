<?php

namespace App\Artists\Infrastructure\Symfony\Model;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use App\Artists\Domain\Entity\Artist;
use App\Artists\Infrastructure\ApiPlatform\State\Provider\AlbumProvider;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'Album',
    
    operations: [
        new Get(),
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['Album:Read']],    
    provider: AlbumProvider::class,
)]
final class Album
{
    private string $id;
    #[Groups('Album:Read')]
    private ?string $name = null;
    #[Groups('Album:Read')]

    private Artist $artist;

    #[Groups('Album:Read')]
    private Collection $songs;

    public function __construct(){
        $this->songs = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUser(): ?Artist
    {
        return $this->artist;
    }

    public function setUser(Artist $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getSongs(): ?Collection
    {
        return $this->songs;
    }

    public function setSongs(Collection $songs): self
    {
        $this->songs = $songs;

        return $this;
    }

    public function getArtist(): Artist
    {
        return $this->artist;
    }

    public function setArtist(Artist $artist): self
    {
        $this->artist = $artist;

        return $this;
    }
}