<?php

namespace App\Tests\Service;

use App\Entity\Customer;
use App\Service\CustomerService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CustomerServiceTest extends TestCase
{
    public function testCreateCustomer()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $passwordHasher = $this->createMock(UserPasswordHasherInterface::class);
        $passwordHasher->expects($this->once())
            ->method('hashPassword')
            ->willReturn('hashed_password');

        $entityManager->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Customer::class));
        
        $entityManager->expects($this->once())
            ->method('flush');

        $customerService = new CustomerService($entityManager, $passwordHasher);

        $customer = $customerService->createCustomer('John', 'Doe', '1234567890', 'john.doe@example.com', 'plain_password');

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertSame('John', $customer->getName());
        $this->assertSame('Doe', $customer->getSurname());
        $this->assertSame('1234567890', $customer->getPhone());
        $this->assertSame('john.doe@example.com', $customer->getEmail());
        $this->assertSame('hashed_password', $customer->getPassword());
    }
}
