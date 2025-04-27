<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\DateTimeProcessor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AppController extends AbstractController
{
    public function __construct(
        private readonly DateTimeProcessor $dateTimeProcessor
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

        $result = $this->dateTimeProcessor->processDateTimeData($rawData);

        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
            'message' => $result['message'],
            'debug_info' => $result['processed_data']
        ]);
    }
}
