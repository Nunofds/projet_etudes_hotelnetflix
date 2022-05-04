<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use function Sodium\add;

// TOUT CE QUI CONCERNE LE BACKOFFICE USER
// - Ajouter une réservation/Supprimer une réservation /Modifier une réservation

class UserController extends AbstractController
{
    #[Route('/user', name: 'user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/profile', name: 'user_profile')]
    public function showProfil(): Response
    {
        return $this->render('user/profile.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/modify', name: 'user_modify', methods: ['GET', 'POST'])]
    public function modify(Request $request, UserRepository $UserRepository): Response
    {
        $user=$this->getUser();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $UserRepository->add($user);
            return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);

            if( $mdp = $form->get('password')->getData() ){
                $password = $hasher->hashPassword($user, $mdp);
                $user->setPassword( $password );
            }

        }

        return $this->renderForm('user/modify.html.twig', [
            'registrationForm' => $form
        ]);
    }

    #[Route('/user/bookings', name: 'user_bookings')]
    public function showBookings(): Response
    {
        return $this->render('user/bookings.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

}
