<?php

namespace App\Customers\Infrastructure\Symfony\Controller;

use App\Customers\Domain\Entity\Playlist;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Customers\Domain\Repository\PlaylistRepository;
use App\Customers\Infrastructure\Symfony\Form\PlaylistFormType;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/playlist')]
class PlaylistController extends AbstractController
{
    #[Route('/', name: 'app_playlist_index', methods: ['GET'])]
    public function index(PlaylistRepository $playlistRepository): Response
    {
        $user = $this->getUser();
        $playlists = $playlistRepository->findBy(['user' => $user]);
        return $this->render('playlist/index.html.twig', [
            'playlists' => $playlists,
        ]);
    }

    #[Route('/new', name: 'app_playlist_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, PlaylistRepository $playlistRepository): Response
    {
        $playlist = new Playlist();

        $user = $this->getUser();
        $playlist->setUser($user);

        $form = $this->createForm(PlaylistFormType::class, $playlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $playlistRepository->save($playlist, true);

            return $this->redirectToRoute('app_homepage', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('playlist/new.html.twig', [
            'playlist' => $playlist,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_playlist_delete', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function delete(Request $request, Playlist $playlist, PlaylistRepository $playlistRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$playlist->getId(), $request->request->get('_token'))) {
            $playlistRepository->remove($playlist, true);
        }

        return $this->redirectToRoute('app_homepage', [], Response::HTTP_SEE_OTHER);
    }
}
