<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\DTO\UserData;
use App\Service\UserDataService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;

class UserDataServiceTest extends TestCase
{
    private UserDataService $userDataService;

    protected function setUp(): void
    {
        $validator = Validation::createValidatorBuilder()
            ->getValidator();

        $this->userDataService = new UserDataService($validator);
    }

    public function testCreateFromJsonWithValidData(): void
    {
        $jsonData = json_encode([
            'name' => 'John Doe',
            'age' => 30,
            'email' => 'john@example.com',
            'phone' => '0123456789'
        ]);

        $userData = $this->userDataService->createFromJson($jsonData);

        $this->assertInstanceOf(UserData::class, $userData);
        $this->assertEquals('John Doe', $userData->getName());
        $this->assertEquals(30, $userData->getAge());
        $this->assertEquals('john@example.com', $userData->getEmail());
        $this->assertEquals('0123456789', $userData->getPhone());
    }

    public function testCreateFromJsonWithInvalidJson(): void
    {
        $this->expectException(\JsonException::class);
        $this->userDataService->createFromJson('invalid json');
    }

    public function testCreateFromJsonWithMissingData(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->userDataService->createFromJson('{"name": "John Doe"}');
    }
} 