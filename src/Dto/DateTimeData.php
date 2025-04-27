<?php

declare(strict_types=1);

namespace App\Dto;

/**
 * DTO représentant des données temporelles.
 * Cette classe est immuable (readonly) pour garantir l'intégrité des données.
 */
final class DateTimeData
{
    public function __construct(
        private readonly int $day,
        private readonly int $month,
        private readonly int $year,
        private readonly int $timestamp,
        private readonly string $timezone
    ) {
        $this->validate();
    }

    /**
     * Valide les données temporelles
     *
     * @throws \InvalidArgumentException Si les données sont invalides
     */
    private function validate(): void
    {
        if ($this->day < 1 || $this->day > 31) {
            throw new \InvalidArgumentException('Le jour doit être compris entre 1 et 31');
        }

        if ($this->month < 1 || $this->month > 12) {
            throw new \InvalidArgumentException('Le mois doit être compris entre 1 et 12');
        }

        if ($this->year < 1900 || $this->year > 2100) {
            throw new \InvalidArgumentException('L\'année doit être comprise entre 1900 et 2100');
        }

        if (empty($this->timezone)) {
            throw new \InvalidArgumentException('Le fuseau horaire ne peut pas être vide');
        }
    }

    public function getDay(): int
    {
        return $this->day;
    }

    public function getMonth(): int
    {
        return $this->month;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getTimezone(): string
    {
        return $this->timezone;
    }

    public function isEvenDay(): bool
    {
        return $this->day % 2 === 0;
    }

    /**
     * Crée une instance à partir d'un tableau
     *
     * @param array{day: string|int, month: string|int, year: string|int, timestamp: string|int, timezone: string} $data
     * @return self
     * @throws \InvalidArgumentException Si les données sont invalides ou incomplètes
     */
    public static function fromArray(array $data): self
    {
        $requiredKeys = ['day', 'month', 'year', 'timestamp', 'timezone'];
        foreach ($requiredKeys as $key) {
            if (!isset($data[$key])) {
                throw new \InvalidArgumentException(sprintf('La clé "%s" est manquante', $key));
            }
        }

        return new self(
            (int) $data['day'],
            (int) $data['month'],
            (int) $data['year'],
            (int) $data['timestamp'],
            $data['timezone']
        );
    }
} 