<?php

declare(strict_types=1);

namespace App\Tests\Service;

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
            'jour' => '15',
            'mois' => '04',
            'année' => '2024',
            'timestamp' => 1713110400,
            'timezone' => 'Europe/Paris'
        ];

        $result = $this->processor->processDateTimeData($inputData);
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('message', $result);
        $this->assertArrayHasKey('processed_data', $result);
        
        $processedData = $result['processed_data'];
        $this->assertEquals(15, $processedData['day']);
        $this->assertEquals('04', $processedData['month']);
        $this->assertEquals('2024', $processedData['year']);
        $this->assertEquals(1713110400, $processedData['timestamp']);
        $this->assertEquals('Europe/Paris', $processedData['timezone']);
        $this->assertFalse($processedData['is_even']);
    }

    public function testProcessDateTimeDataWithEvenDay(): void
    {
        $inputData = [
            'jour' => '16',
            'mois' => '04',
            'année' => '2024',
            'timestamp' => 1713110400,
            'timezone' => 'Europe/Paris'
        ];

        $result = $this->processor->processDateTimeData($inputData);
        
        $this->assertTrue($result['processed_data']['is_even']);
        $this->assertStringContainsString('PAIR', $result['message']);
    }
} 