<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ReviewsRepository;


// TOUT CE QUI CONCERNE LES AFFICHAGES SUR LA PAGE D'ACCUEIL
// - Affichage du swip séries dynamiquement
// - Affichage des formules statique
// - Affichage du formulaire réservation (select séries + select formules)
// - Affichage du swip review dynamiquement

#[Route('/')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(SerieRepository $serieRepository, ReviewsRepository $reviewsRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'series' => $serieRepository->findAll(),
            'reviews' => $reviewsRepository->findAll()
        ]);
    }

    #[Route('/{id}', name: 'app_hotel_show', methods: ['GET'], requirements: ['id' => '[0-9]+'])]
    public function showHotel(Serie $serie): Response
    {
        return $this->render('home/hotel.html.twig', [
            'serie' => $serie,
        ]);
    }
    
    #[Route("/mentionsLegales", name:"app_mentions_legales")]
    public function mentionsLegales(): Response
    {
       return $this->render('home/mentions_legales.html.twig', [
       ]);
    }

}
