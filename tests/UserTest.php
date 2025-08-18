<?php

namespace App\Tests\Unit;

use App\Entity\User;
use App\Repository\UserRepository;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManagerInterface;

class UserTest extends TestCase
{
    public function testEmailValidation(): void
    {
        $user = new User();
        $user->setEmail('testy.com');
        $emailTest = "test@example.com";

        $userRepository = $this->createMock(UserRepository::class);
        

        $this->assertTrue(filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL) !== false);

    }
}

