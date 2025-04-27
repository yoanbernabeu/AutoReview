<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\ReviewDataProcessor;
use PHPUnit\Framework\TestCase;

class ReviewDataProcessorTest extends TestCase
{
    private ReviewDataProcessor $processor;

    protected function setUp(): void
    {
        $this->processor = new ReviewDataProcessor();
    }

    public function testGenerateReviewData(): void
    {
        $generator = $this->processor->generateReviewData();
        $firstReview = $generator->current();
        
        $this->assertIsArray($firstReview);
        $this->assertArrayHasKey('id', $firstReview);
        $this->assertArrayHasKey('title', $firstReview);
        $this->assertArrayHasKey('content', $firstReview);
    }

    public function testProcessReviewData(): void
    {
        $inputData = [
            ['id' => 1, 'title' => 'test', 'content' => 'content']
        ];

        $result = $this->processor->processReviewData($inputData);
        
        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertEquals('TEST', $result[0]['title']);
        $this->assertArrayHasKey('processed_at', $result[0]);
    }
} 