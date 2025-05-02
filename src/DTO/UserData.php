<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class UserData
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 2, max: 255)]
        private readonly string $name,

        #[Assert\NotBlank]
        #[Assert\Range(min: 0, max: 150)]
        private readonly int $age,

        #[Assert\NotBlank]
        #[Assert\Email]
        private readonly string $email,

        #[Assert\NotBlank]
        #[Assert\Regex(
            pattern: '/^\+[1-9][0-9]{10,14}$/',
            message: 'Le numéro de téléphone doit être au format international (ex: +33612345678)'
        )]
        private readonly string $phone,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }
} 