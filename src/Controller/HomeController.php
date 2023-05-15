<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController  extends AbstractController
{

    public function index(PropertyRepository $repository) : Response
    {

        $property = $repository->findLatest();


        return new Response($this->render('pages/home.html.twig',
        [
            'properties' => $property
        ]));
    }

}