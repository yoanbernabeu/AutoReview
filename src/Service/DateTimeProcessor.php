<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\DateTimeData;

class DateTimeProcessor
{
    /**
     * Traite les données temporelles et génère un message formaté
     *
     * @param array{day: string, month: string, year: string, timestamp: int, timezone: string} $dateTimeData
     * @return array{message: string, processed_data: DateTimeData}
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
     */
    private function formatMessage(DateTimeData $data): string
    {
        return sprintf(
            "Jour %d: %s\nMois: %s\nAnnée: %s\nTimestamp: %d\nTimezone: %s",
            $data->getDay(),
            $data->isEvenDay() ? 'PAIR' : 'IMPAIR',
            $data->getMonth(),
            $data->getYear(),
            $data->getTimestamp(),
            $data->getTimezone()
        );
    }
} 