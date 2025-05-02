<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\UserDataService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use JsonException;

/**
 * Contrôleur de démonstration pour le traitement des données utilisateur.
 * 
 * Endpoint POST /demo
 * Attend un JSON avec la structure suivante :
 * {
 *     "name": "string",
 *     "age": "integer",
 *     "email": "string",
 *     "phone": "string" (format international: +33612345678)
 * }
 */
final class DemoController extends AbstractController
{
    public function __construct(
        private readonly UserDataService $userDataService
    ) {
    }

    #[Route('/demo', name: 'app_demo', methods: ['POST'])]
    public function index(Request $request): Response
    {
        try {
            $userData = $this->userDataService->createFromJson($request->getContent());

            return $this->render('demo/index.html.twig', [
                'controller_name' => 'DemoController',
                'userData' => $userData,
            ]);
        } catch (JsonException $e) {
            return $this->json(['error' => 'Invalid JSON format'], Response::HTTP_BAD_REQUEST);
        } catch (\InvalidArgumentException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
