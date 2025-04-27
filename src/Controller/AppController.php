<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ReviewDataProcessor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AppController extends AbstractController
{
    public function __construct(
        private readonly ReviewDataProcessor $reviewDataProcessor
    ) {
    }

    #[Route('/app', name: 'app_app')]
    public function index(): Response
    {
        $currentTime = new \DateTime();
        $rawData = [
            'jour' => $currentTime->format('j'),
            'mois' => $currentTime->format('m'),
            'année' => $currentTime->format('Y'),
            'timestamp' => $currentTime->getTimestamp(),
            'timezone' => $currentTime->getTimezone()->getName()
        ];

        $processedData = $this->reviewDataProcessor->processReviewData($rawData);

        $message = sprintf(
            "Jour %d: %s\nMois: %s\nAnnée: %s\nTimestamp: %d\nTimezone: %s",
            $processedData['jour'],
            $processedData['jour'] % 2 === 0 ? 'PAIR' : 'IMPAIR',
            $processedData['mois'],
            $processedData['année'],
            $processedData['timestamp'],
            $processedData['timezone']
        );

        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
            'message' => $message,
            'debug_info' => $processedData
        ]);
    }
}
