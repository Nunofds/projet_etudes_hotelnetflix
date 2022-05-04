<?php

namespace App\Controller\Admin;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/serie')]
class SerieController extends AbstractController
{
    #[Route('/', name: 'app_admin_serie_index', methods: ['GET'])]
    public function index(SerieRepository $serieRepository): Response
    {
        return $this->render('admin/serie/index.html.twig', [
            'series' => $serieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_serie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SerieRepository $serieRepository, SluggerInterface $slugger, EntityManagerInterface $em): Response
    {
        $serie = new Serie();
        $form = $this->createForm(SerieType::class, $serie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // image serie
            $img_serie = $form->get('image_serie')->getData();
            if ($img_serie) {
                // create a new file name
                $originalFilename = pathinfo($img_serie->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$img_serie->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $img_serie->move(
                        $this->getParameter('img_serie_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $serie->setImageSerie($newFilename);
            }
            // image basic
            $img_basic = $form->get('image_basic')->getData();
            if ($img_basic) {
                // create a new file name
                $originalFilename = pathinfo($img_basic->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$img_basic->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $img_basic->move(
                        $this->getParameter('img_formules_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $serie->setImageBasic($newFilename);
            }
            // image immersive
            $img_immersive = $form->get('image_immersive')->getData();
            if ($img_immersive) {
                // create a new file name
                $originalFilename = pathinfo($img_immersive->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$img_immersive->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $img_immersive->move(
                        $this->getParameter('img_formules_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $serie->setImageImmersive($newFilename);
            }
            // image deluxe
            $img_deluxe = $form->get('image_deluxxe')->getData();
            if ($img_deluxe) {
                // create a new file name
                $originalFilename = pathinfo($img_deluxe->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$img_deluxe->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $img_deluxe->move(
                        $this->getParameter('img_formules_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $serie->setImageDeluxxe($newFilename);
            }
            // image hotel
            $img_hotel = $form->get('image_hotel')->getData();
            if ($img_hotel) {
                // create a new file name
                $originalFilename = pathinfo($img_hotel->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$img_hotel->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $img_hotel->move(
                        $this->getParameter('img_formules_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $serie->setImageHotel($newFilename);
            }

            // envoie en bdd
            $em->persist($serie);
            $em->flush();

            return $this->redirectToRoute('app_admin_serie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/serie/new.html.twig', [
            'serie' => $serie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_serie_show', methods: ['GET'])]
    public function show(Serie $serie): Response
    {
        return $this->render('admin/serie/show.html.twig', [
            'serie' => $serie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_serie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Serie $serie, SluggerInterface $slugger, SerieRepository $serieRepository, $id): Response
    {
        $image = $serieRepository->find($id); // test
        $form = $this->createForm(SerieType::class, $serie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $img_serie = $form->get('image_serie')->getData();
            if ($img_serie) {
                // create a new file name
                $originalFilename = pathinfo($img_serie->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$img_serie->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $img_serie->move(
                        $this->getParameter('img_serie_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $serie->setImageSerie($newFilename);
            }
            // image basic
            $img_basic = $form->get('image_basic')->getData();
            if ($img_basic) {
                // create a new file name
                $originalFilename = pathinfo($img_basic->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$img_basic->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $img_basic->move(
                        $this->getParameter('img_formules_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $serie->setImageBasic($newFilename);
            }
            // image immersive
            $img_immersive = $form->get('image_immersive')->getData();
            if ($img_immersive) {
                // create a new file name
                $originalFilename = pathinfo($img_immersive->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$img_immersive->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $img_immersive->move(
                        $this->getParameter('img_formules_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $serie->setImageImmersive($newFilename);
            }
            // image deluxe
            $img_deluxe = $form->get('image_deluxxe')->getData();
            if ($img_deluxe) {
                // create a new file name
                $originalFilename = pathinfo($img_deluxe->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$img_deluxe->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $img_deluxe->move(
                        $this->getParameter('img_formules_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $serie->setImageDeluxxe($newFilename);
            }
            // image hotel
            $img_hotel = $form->get('image_hotel')->getData();
            if ($img_hotel) {
                // create a new file name
                $originalFilename = pathinfo($img_hotel->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$img_hotel->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $img_hotel->move(
                        $this->getParameter('img_formules_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $serie->setImageHotel($newFilename);
            }

            $serieRepository->add($serie);
            return $this->redirectToRoute('app_admin_serie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/serie/edit.html.twig', [
            'serie' => $serie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_serie_delete', methods: ['POST'])]
    public function delete(Request $request, Serie $serie, SerieRepository $serieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$serie->getId(), $request->request->get('_token'))) {
            $serieRepository->remove($serie);
        }

        return $this->redirectToRoute('app_admin_serie_index', [], Response::HTTP_SEE_OTHER);
    }

}

