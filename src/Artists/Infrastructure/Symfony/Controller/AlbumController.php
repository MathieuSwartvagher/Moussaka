<?php

namespace App\Artists\Infrastructure\Symfony\Controller;

use App\Artists\Domain\Entity\Album;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Artists\Domain\Repository\AlbumRepository;
use App\Artists\Infrastructure\Symfony\Form\AlbumType;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/album')]
class AlbumController extends AbstractController
{
    #[Route('/', name: 'app_album_index', methods: ['GET'])]
    #[IsGranted('ROLE_ARTIST')]
    public function index(AlbumRepository $albumRepository): Response
    {
        $artist = $this->getUser()->getFirstArtist();
        $albums = $albumRepository->findBy(['artist' => $artist]);
        return $this->render('album/index.html.twig', [
            'albums' => $albums,
        ]);
    }

    #[Route('/new', name: 'app_album_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ARTIST')]
    public function new(Request $request, AlbumRepository $albumRepository): Response
    {
        $album = new Album();

        $artist = $this->getUser()->getFirstArtist();
        $album->setArtist($artist);

        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $albumRepository->save($album, true);

            return $this->redirectToRoute('app_homepage', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('album/new.html.twig', [
            'album' => $album,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_album_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ARTIST')]
    public function delete(Request $request, Album $album, AlbumRepository $albumRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$album->getId(), $request->request->get('_token'))) {
            $albumRepository->remove($album, true);
        }

        return $this->redirectToRoute('app_homepage', [], Response::HTTP_SEE_OTHER);
    }
}
