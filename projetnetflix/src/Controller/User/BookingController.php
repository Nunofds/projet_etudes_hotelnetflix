<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/user/booking')]
class BookingController extends AbstractController
{
    #[Route('/', name: 'app_user_booking_index', methods: ['GET'])]
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('user/booking/index.html.twig', [
            'bookings' => $bookingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_booking_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BookingRepository $bookingRepository): Response
    {
        $booking = new Booking();
        $booking ->setUser($this->getUser());

        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($booking->getCheckout() > $booking->getCheckin())    {
                $OverlapCheckin = $bookingRepository->findOneBookingByCheckin($booking->getCheckin(), $booking->getSerie(), $booking->getFormule()) ;
                $OverlapCheckout = $bookingRepository->findOneBookingByCheckout($booking->getCheckout(), $booking->getSerie(), $booking->getFormule()) ;
                $OverlapBoth = $bookingRepository->findOneBookingByBoth($booking->getCheckin(), $booking->getCheckout(), $booking->getSerie(), $booking->getFormule()) ;
                if (empty($OverlapCheckin) && empty($OverlapCheckout) && empty($OverlapBoth)){
                    $bookingRepository->add($booking);
                    return $this->redirectToRoute('app_user_booking_index', [], Response::HTTP_SEE_OTHER);
                }
                else {
                    $this->addFlash('danger', "Les dates sont pas disponibles, merci de choisir d'autres dates");
                }
            }
            else {
                $this->addFlash('danger', "La date de fin de séjour doit être supérieure à la date de début de séjour");
            }
        }



        return $this->renderForm('user/booking/new.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_booking_show', methods: ['GET'])]
    public function show(Booking $booking): Response
    {
        return $this->render('user/booking/show.html.twig', [
            'booking' => $booking,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_booking_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Booking $booking, BookingRepository $bookingRepository): Response
    {
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);
        $reservations=$bookingRepository->findAll();
        if ($form->isSubmitted() && $form->isValid()) {
            foreach($reservations as $reservation ) {
                if ($booking->getCheckout() > $booking->getCheckin()){
                    if (($reservation->getSerie()==$booking->getSerie()) && ($reservation->getFormule()==$booking->getFormule()) &&  ($reservation->getId()!='{id}')){
                        if ((($reservation->getCheckin() <= $booking->getCheckin()) && ($reservation->getCheckout()>= $booking->getCheckin()))
                            || (($reservation->getCheckin() <= $booking->getCheckout()) && ($reservation->getCheckout()>= $booking->getCheckout()))
                            || (($reservation->getCheckin() >= $booking->getCheckin()) && ($reservation->getCheckout()<= $booking->getCheckout()))){
                            $this->addFlash('danger', "Ces dates en sont pas disponibles, merci de choisir d'autres dates");

                        }
                    } else {
                        $bookingRepository->add($booking);
                        return $this->redirectToRoute('app_user_booking_index', [], Response::HTTP_SEE_OTHER);
                    }
                } else {
                    $this->addFlash('danger', "Ces dates en sont pas disponibles, merci de choisir d'autres dates");
                }
            }


        }

        return $this->renderForm('user/booking/new.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_booking_delete', methods: ['POST'])]
    public function delete(Request $request, Booking $booking, BookingRepository $bookingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $bookingRepository->remove($booking);
        }

        return $this->redirectToRoute('app_user_booking_index', [], Response::HTTP_SEE_OTHER);
    }
}

