<?php

declare(strict_types=1);

namespace App\Service;

class DateTimeProcessor
{
    /**
     * Traite les données temporelles et génère un message formaté
     *
     * @param array $dateTimeData Données temporelles (jour, mois, année, etc.)
     * @return array{message: string, processed_data: array}
     */
    public function processDateTimeData(array $dateTimeData): array
    {
        $processedData = $this->transformDateTimeData($dateTimeData);
        
        $message = $this->formatMessage($processedData);
        
        return [
            'message' => $message,
            'processed_data' => $processedData
        ];
    }

    /**
     * Transforme les données temporelles
     *
     * @param array $data
     * @return array
     */
    private function transformDateTimeData(array $data): array
    {
        return [
            'day' => (int) $data['jour'],
            'month' => $data['mois'],
            'year' => $data['année'],
            'timestamp' => $data['timestamp'],
            'timezone' => $data['timezone'],
            'is_even' => (int) $data['jour'] % 2 === 0
        ];
    }

    /**
     * Formate le message avec les données traitées
     *
     * @param array $processedData
     * @return string
     */
    private function formatMessage(array $processedData): string
    {
        return sprintf(
            "Jour %d: %s\nMois: %s\nAnnée: %s\nTimestamp: %d\nTimezone: %s",
            $processedData['day'],
            $processedData['is_even'] ? 'PAIR' : 'IMPAIR',
            $processedData['month'],
            $processedData['year'],
            $processedData['timestamp'],
            $processedData['timezone']
        );
    }
} 