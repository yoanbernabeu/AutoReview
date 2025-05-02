<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DemoControllerTest extends WebTestCase
{
    public function testIndexWithValidData(): void
    {
        $client = static::createClient();

        $data = [
            'name' => 'John Doe',
            'age' => 30,
            'email' => 'john@example.com',
            'phone' => '0123456789'
        ];

        $client->request(
            'POST',
            '/demo',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello DemoController!');
        $this->assertSelectorTextContains('dd', 'John Doe');
    }

    public function testIndexWithInvalidJson(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/demo',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            'invalid json'
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Invalid JSON format', $response['error']);
    }

    public function testIndexWithMissingData(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/demo',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['name' => 'John Doe'])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertStringContainsString('Missing required fields', $response['error']);
    }
} 