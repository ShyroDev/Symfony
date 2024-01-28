<?php

namespace App\Controller\Admin;

use App\Entity\Proprietaire;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminProprietaryController extends AbstractController
{

    private EntityManagerInterface $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function new(Request $request): Response
    {
        $proprietary = new Proprietaire();

        $form = $this->createForm(Proprietaire::class, $proprietary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->persist($proprietary);
            $this->entityManager->flush();
            $this->addFlash('success', 'You have create a new proprietary');

            return $this->redirectToRoute('admin');
        }

        return $this->render('pages/admin/newProprietary.html.twig',
            [
                'proprietary' => $proprietary,
                'form' => $form->createView()
            ]);

    }

    public function  delete(Proprietaire $proprietary, Request $request): Response
    {

        if ($this->isCsrfTokenValid('delete' . $proprietary->getId(), $request->get('_token')))
        {
            $this->entityManager->remove($proprietary);
            $this->entityManager->flush();
            $this->addFlash('success', 'The proprietary as been delete with success');
        } 


        return $this->redirectToRoute('admin');
    }


}