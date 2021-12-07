<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MuestraController extends AbstractController
{
    #[Route('/muestra', name: 'muestra')]
    public function index(): Response
    {
        return $this->render('muestra/index.html.twig', [
            'controller_name' => 'MuestraController',
        ]);
    }
}
