<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
final class DemoController extends AbstractController
{
    #[Route('/demo', name: 'app_demo')]
    public function index(Request $request): Response
    {
        // 1. Récupérer les données soumises par un POST API au format JSON

        $data = $request->getContent();

        // 2. Convertir les données JSON en objet PHP

        $data = json_decode($data);

        return $this->render('demo/index.html.twig', [
            'controller_name' => 'DemoController',
            'data' => $data,
        ]);
    }
}
