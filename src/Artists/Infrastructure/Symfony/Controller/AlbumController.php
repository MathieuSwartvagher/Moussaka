<?php

namespace App\Artists\Infrastructure\Symfony\Controller;

use App\Artists\Application\Message\DeleteAlbum;
use App\Artists\Infrastructure\Symfony\Model\Album;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Artists\Infrastructure\Symfony\Form\AlbumType;
use App\Artists\Application\Message\FindAlbumQuery;
use App\Artists\Application\Message\ManageAlbum;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/album')]
class AlbumController extends AbstractController
{
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    #[Route('/', name: 'app_album_index', methods: ['GET'])]
    #[IsGranted('ROLE_ARTIST')]
    public function index(): Response
    {
        $artists = $this->getUser()->getMyArtists();
        $enveloppe = $this->messageBus->dispatch(new FindAlbumQuery($artists));
        $lastStamp = $enveloppe->last(HandledStamp::class);
        $albums = $lastStamp->getResult();
        return $this->render('album/index.html.twig', [
            'albums' => $albums,
        ]);
    }

    #[Route('/new', name: 'app_album_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ARTIST')]
    public function new(Request $request): Response
    {
        $album = new Album();
        
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {     
            $this->messageBus->dispatch(new ManageAlbum($album));

            return $this->redirectToRoute('app_homepage', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('album/new.html.twig', [
            'album' => $album,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_album_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ARTIST')]
    public function delete(Request $request): Response
    {
        $id = $request->get('id');

        $this->messageBus->dispatch(new DeleteAlbum($id));
        return $this->redirectToRoute('app_homepage', [], Response::HTTP_SEE_OTHER);
    }
}
