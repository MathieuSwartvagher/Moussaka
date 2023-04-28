<?php

namespace App\Customers\Infrastructure\Symfony\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Customers\Application\Message\DeletePlaylist;
use App\Customers\Application\Message\ManagePlaylist;
use App\Customers\Domain\Repository\PlaylistRepository;
use App\Customers\Application\Message\FindPlaylistQuery;
use App\Customers\Infrastructure\Symfony\Model\Playlist;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Customers\Infrastructure\Symfony\Form\PlaylistFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/playlist')]
class PlaylistController extends AbstractController
{
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    #[Route('/', name: 'app_playlist_index', methods: ['GET'])]
    public function index(): Response
    {
        $user = $this->getUser();

        $enveloppe = $this->messageBus->dispatch(new FindPlaylistQuery($user));
        $lastStamp = $enveloppe->last(HandledStamp::class);
        $playlists = $lastStamp->getResult();

        return $this->render('playlist/index.html.twig', [
            'playlists' => $playlists,
        ]);
    }

    #[Route('/new', name: 'app_playlist_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request): Response
    {
        $playlist = new Playlist();
        
        $form = $this->createForm(PlaylistFormType::class, $playlist);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {  
            $playlist->setUser($this->getUser()); 
            $this->messageBus->dispatch(new ManagePlaylist($playlist));

            return $this->redirectToRoute('app_homepage', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('playlist/new.html.twig', [
            'playlist' => $playlist,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_playlist_delete', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function delete(string $id): Response
    {
        $this->messageBus->dispatch(new DeletePlaylist($id));

        return $this->redirectToRoute('app_homepage', [], Response::HTTP_SEE_OTHER);
    }
}
