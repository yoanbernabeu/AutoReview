<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\DateTimeData;

/**
 * Service de traitement des données temporelles
 */
class DateTimeProcessor
{
    /**
     * Traite les données temporelles et génère un message formaté
     *
     * @param array{day: string|int, month: string|int, year: string|int, timestamp: string|int, timezone: string} $dateTimeData
     * @return array{message: string, processed_data: DateTimeData}
     * @throws \InvalidArgumentException Si les données sont invalides
     */
    public function processDateTimeData(array $dateTimeData): array
    {
        $processedData = DateTimeData::fromArray($dateTimeData);
        $message = $this->formatMessage($processedData);
        
        return [
            'message' => $message,
            'processed_data' => $processedData
        ];
    }

    /**
     * Formate le message avec les données traitées
     *
     * @param DateTimeData $data Données temporelles validées
     * @return string Message formaté
     */
    private function formatMessage(DateTimeData $data): string
    {
        return sprintf(
            "Jour %d: %s\nMois: %d\nAnnée: %d\nTimestamp: %d\nTimezone: %s",
            $data->getDay(),
            $data->isEvenDay() ? 'PAIR' : 'IMPAIR',
            $data->getMonth(),
            $data->getYear(),
            $data->getTimestamp(),
            $data->getTimezone()
        );
    }
} 