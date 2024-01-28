<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\PropertyResearch;
use App\Form\PropertyResearchType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
class PropertiesController extends AbstractController
{


    private PropertyRepository $repositoy;

    public function __construct(PropertyRepository $property)
    {
        $this->repositoy = $property;

    }



    public function index(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
    {

        $research = new PropertyResearch();

        $form = $this->createForm(PropertyResearchType::class, $research);
        $form->handleRequest($request);

        $property = $paginator->paginate($this->repositoy->findAllVisibleQuery($research),
            $request->query->getInt('page', 1), 12);


        return new Response($this->render('pages/properties.html.twig',
            [
                'current_menu' => 'properties',
                'properties' => $property,
                'form' => $form->createView()
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

        $proprietary = $property->getProprietary();

        return $this->render('pages/show.html.twig',
        [
            'proprietarys' => $proprietary,
            'properties' => $property,
            'current_menu' => 'properties'
        ]);
    }

}
