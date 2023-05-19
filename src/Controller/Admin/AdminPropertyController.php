<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private PropertyRepository $repository;
    private EntityManagerInterface $entityManager;


    public function __construct(PropertyRepository $repository,EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }



    public function index(): Response
    {
        $properties = $this->repository->findAll();
        return $this->render('pages/admin/property.html.twig', compact("properties"));
    }


    public function new(Request $request): Response
    {
        $property = new Property();

        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->persist($property);
            $this->entityManager->flush();
            $this->addFlash('success', 'You have create a new property');

            return $this->redirectToRoute('admin');
        }

        return $this->render('pages/admin/new.html.twig',
            [
                'property' => $property,
                'form' => $form->createView()
            ]);

    }



    public function edit(Property $property, Request $request): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->flush();
            $this->addFlash('success', 'Your modification as been save');

            return $this->redirectToRoute('admin');
        }

        return $this->render('pages/admin/edit.html.twig',
        [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }


    public function  delete(Property $property, Request $request): Response
    {

        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token')))
        {
            $this->entityManager->remove($property);
            $this->entityManager->flush();
            $this->addFlash('success', 'Your property as been delete with success');
        }


        return $this->redirectToRoute('admin');
    }



}
