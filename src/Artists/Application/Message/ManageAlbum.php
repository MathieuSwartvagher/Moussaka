<?php

namespace App\Artists\Application\Message;

use App\Artists\Infrastructure\Symfony\Model\Album;
use App\Artists\Domain\Entity\Album as DomainAlbum;
use Symfony\Component\Form\FormInterface;

final class ManageAlbum
{
    public function __construct(public Album|DomainAlbum $album)
    {
    }
}
