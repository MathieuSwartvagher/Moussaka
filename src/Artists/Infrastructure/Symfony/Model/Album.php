<?php

namespace App\Artists\Infrastructure\Symfony\Model;

use App\Artists\Domain\Entity\Artist;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

final class Album
{
    private string $id;
    private ?string $name = null;
    private Artist $artist;
    /**
    * @var Collection<Song>
    */
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