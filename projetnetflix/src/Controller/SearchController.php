<?php

namespace App\Controller;

use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(Request $request, SerieRepository $serieRepository): Response
    {
        $word = $request->query->get('search');
        $series = $serieRepository->findBySearch($word);

        return $this->render('search/index.html.twig', [
            'series' => $series,
            'word' => $word
        ]);
    }
}
