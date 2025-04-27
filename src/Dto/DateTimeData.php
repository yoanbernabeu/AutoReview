<?php

declare(strict_types=1);

namespace App\Dto;

final class DateTimeData
{
    public function __construct(
        private readonly int $day,
        private readonly string $month,
        private readonly string $year,
        private readonly int $timestamp,
        private readonly string $timezone
    ) {
    }

    public function getDay(): int
    {
        return $this->day;
    }

    public function getMonth(): string
    {
        return $this->month;
    }

    public function getYear(): string
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

    public static function fromArray(array $data): self
    {
        return new self(
            (int) $data['day'],
            $data['month'],
            $data['year'],
            (int) $data['timestamp'],
            $data['timezone']
        );
    }
} 