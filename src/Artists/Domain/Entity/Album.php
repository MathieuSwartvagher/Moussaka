<?php

namespace App\Artists\Domain\Entity;

use App\Artists\Domain\Repository\AlbumRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Artists\Domain\Entity\Artist;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
final class Album
{
    #[
        ORM\Column(type: 'uuid'),
        ORM\Id
    ]
    private string $id;
    #[ORM\Column]
    private ?string $name = null;
    #[ORM\ManyToOne(targetEntity: Artist::class, inversedBy: 'albums')]
    private Artist $artist;

    /**
    * @var Collection<Song>
    */
    #[ORM\OneToMany(mappedBy: 'album', targetEntity: Song::class, cascade: ['persist'])]
    private Collection $songs;

    public function __construct(){
        $this->id = (string) (new UuidV4());
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