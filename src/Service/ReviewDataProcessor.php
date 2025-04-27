<?php

declare(strict_types=1);

namespace App\Service;

class ReviewDataProcessor
{
    /**
     * Génère des données de test pour les revues
     *
     * @return \Generator
     */
    public function generateReviewData(): \Generator
    {
        $reviews = [
            ['id' => 1, 'title' => 'Première revue', 'content' => 'Contenu de la première revue'],
            ['id' => 2, 'title' => 'Deuxième revue', 'content' => 'Contenu de la deuxième revue'],
            ['id' => 3, 'title' => 'Troisième revue', 'content' => 'Contenu de la troisième revue'],
        ];

        foreach ($reviews as $review) {
            yield $review;
        }
    }

    /**
     * Traite les données des revues
     *
     * @param array $data
     * @return array
     */
    public function processReviewData(array $data): array
    {
        return array_map(function ($item) {
            return [
                'id' => $item['id'],
                'title' => strtoupper($item['title']),
                'content' => $item['content'],
                'processed_at' => (new \DateTime())->format('Y-m-d H:i:s')
            ];
        }, $data);
    }
} 