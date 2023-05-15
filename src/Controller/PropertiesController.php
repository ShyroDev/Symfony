<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
class PropertiesController extends AbstractController
{


    private PropertyRepository $repositoy;

    public function __construct(PropertyRepository $property)
    {
        $this->repositoy = $property;

    }



    public function index(EntityManagerInterface $entityManager): Response
    {
        return new Response($this->render('pages/properties.html.twig',
        [
            'current_menu' => 'properties'
        ]));
    }




    /**
     * @param string $slug
     * @param Property $property
     * @return Response
     */
    public function show(string $slug,Property $property): Response
    {

        if ($property->getSlug() !== $slug)
        {
            return $this->redirectToRoute('property',
            [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }



        return $this->render('pages/show.html.twig',
        [
            'properties' => $property,
            'current_menu' => 'properties'
        ]);
    }

}
