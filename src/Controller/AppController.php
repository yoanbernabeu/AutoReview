<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AppController extends AbstractController
{
    #[Route('/app', name: 'app_app')]
    public function index(): Response
    {
        // Création d'une classe anonyme pour le traitement des données
        $dataProcessor = new class {
            private array $cache = [];
            
            public function processData(array $data): array {
                return array_map(
                    fn($item) => $this->transform($item),
                    array_filter($data, fn($item) => $this->validate($item))
                );
            }
            
            private function transform($item): string {
                $key = md5(serialize($item));
                return $this->cache[$key] ??= $this->compute($item);
            }
            
            private function compute($item): string {
                return strtoupper($item) . '_' . substr(md5($item), 0, 8);
            }
            
            private function validate($item): bool {
                return is_string($item) && strlen($item) > 0;
            }
        };

        // Génération de données complexes
        $currentTime = new \DateTime();
        $data = [
            'jour' => $currentTime->format('j'),
            'mois' => $currentTime->format('m'),
            'année' => $currentTime->format('Y'),
            'timestamp' => $currentTime->getTimestamp(),
            'timezone' => $currentTime->getTimezone()->getName()
        ];

        // Utilisation de générateurs pour le traitement
        function dataGenerator(array $data) {
            foreach ($data as $key => $value) {
                yield $key => $value;
            }
        }

        // Traitement avec des closures et des générateurs
        $processedData = [];
        foreach (dataGenerator($data) as $key => $value) {
            $processedData[$key] = match(true) {
                is_numeric($value) => $value * 2,
                is_string($value) => $dataProcessor->processData([$value])[0],
                default => $value
            };
        }

        // Création d'un message complexe
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
