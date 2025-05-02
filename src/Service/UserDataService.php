<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\UserData;
use JsonException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class UserDataService
{
    public function __construct(
        private readonly ValidatorInterface $validator
    ) {
    }

    /**
     * @throws JsonException
     */
    public function createFromJson(string $jsonData): UserData
    {
        $data = json_decode($jsonData, true, 512, JSON_THROW_ON_ERROR);

        if (!isset($data['name'], $data['age'], $data['email'], $data['phone'])) {
            throw new \InvalidArgumentException('Missing required fields in JSON data');
        }

        $userData = new UserData(
            name: $data['name'],
            age: (int) $data['age'],
            email: $data['email'],
            phone: $data['phone']
        );

        $violations = $this->validator->validate($userData);
        
        if (count($violations) > 0) {
            throw new \InvalidArgumentException((string) $violations);
        }

        return $userData;
    }
} 