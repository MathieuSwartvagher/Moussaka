<?php

namespace App\Customers\Domain\Entity;

use App\Customers\Domain\Entity\User;
use App\Customers\Domain\Repository\PlaylistRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;

#[ORM\Entity(repositoryClass: PlaylistRepository::class)]
class Playlist
{
    #[
        ORM\Column(type: 'uuid'),
        ORM\Id
    ]
    private string $id;
    #[ORM\Column]
    private ?string $name = null;

    /**
    * @var Collection<Song>
    */
    private Collection $songs;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'playlists')]
    private ?User $user;

    public function __construct(){      
        $this->id = (string) (new UuidV4());
        $this->songs =  new ArrayCollection();
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

    public function getSongs(): ?Collection
    {
        return $this->songs;
    }

    public function setSongs(Collection $songs): self
    {
        $this->songs = $songs;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
