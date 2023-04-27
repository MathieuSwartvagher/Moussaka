<?php

namespace App\Artists\Domain\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Translation\Util\ArrayConverter;
use Symfony\Component\Uid\UuidV4;
use App\Customers\Domain\Entity\User;

#[ORM\Entity]
class Artist
{
    #[
        ORM\Column,
        ORM\Id
    ]
    private string $id;
    #[Column]
    private ?string $name = null;
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'artists')]
    private ?User $user;
    /**
     * @var Collection<Song>
     */
    private Collection $songs;
    /**
     * @var Collection<Album>
     */
    #[ORM\OneToMany(mappedBy: 'artist', targetEntity: Album::class, cascade: ['persist'])]
    private Collection $albums;

    public function __construct(){
        $this->id = (string) (new UuidV4());
        $this->songs = new ArrayCollection();        
        $this->albums = new ArrayCollection();
    }

    public function getId(): ?int
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

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

    public function getAlbums(): ?Collection
    {
        return $this->albums;
    }

    public function setAlbums(Collection $albums): self
    {
        $this->albums = $albums;

        return $this;
    }
}
