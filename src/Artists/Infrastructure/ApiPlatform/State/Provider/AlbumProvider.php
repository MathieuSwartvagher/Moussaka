<?php

namespace App\Artists\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Artists\Application\Message\FindAlbumQuery;
use App\Artists\Domain\Entity\Album;
use App\Artists\Infrastructure\Symfony\Model\Album as ModelAlbum;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class AlbumProvider implements ProviderInterface
{
    use HandleTrait;

    public function __construct(private MessageBusInterface $messageBus, private Security $security)
    {
        
    }
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if($operation instanceof Get){
            return $this->handle(new FindAlbumQuery($uriVariables['id']));
        }
        if($operation instanceof GetCollection){
            return $this->handle(new FindAlbumQuery($this->security->getUser()->getMyArtists()));
        }

        throw new \LogicException("Wrong configuration");
    }
}