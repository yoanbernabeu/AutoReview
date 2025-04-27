<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Dto\DateTimeData;
use App\Service\DateTimeProcessor;
use PHPUnit\Framework\TestCase;

class DateTimeProcessorTest extends TestCase
{
    private DateTimeProcessor $processor;

    protected function setUp(): void
    {
        $this->processor = new DateTimeProcessor();
    }

    public function testProcessDateTimeData(): void
    {
        $inputData = [
            'day' => '15',
            'month' => '04',
            'year' => '2024',
            'timestamp' => 1713110400,
            'timezone' => 'Europe/Paris'
        ];

        $result = $this->processor->processDateTimeData($inputData);
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('message', $result);
        $this->assertArrayHasKey('processed_data', $result);
        $this->assertInstanceOf(DateTimeData::class, $result['processed_data']);
        
        $processedData = $result['processed_data'];
        $this->assertEquals(15, $processedData->getDay());
        $this->assertEquals('04', $processedData->getMonth());
        $this->assertEquals('2024', $processedData->getYear());
        $this->assertEquals(1713110400, $processedData->getTimestamp());
        $this->assertEquals('Europe/Paris', $processedData->getTimezone());
        $this->assertFalse($processedData->isEvenDay());
    }

    public function testProcessDateTimeDataWithEvenDay(): void
    {
        $inputData = [
            'day' => '16',
            'month' => '04',
            'year' => '2024',
            'timestamp' => 1713110400,
            'timezone' => 'Europe/Paris'
        ];

        $result = $this->processor->processDateTimeData($inputData);
        
        $this->assertTrue($result['processed_data']->isEvenDay());
        $this->assertStringContainsString('PAIR', $result['message']);
    }
} 