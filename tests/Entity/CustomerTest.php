<?php

namespace App\Tests\Entity;

use App\Entity\Customer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CustomerTest extends TestCase
{
    public function testGetAndSetId()
    {
        $customer = new Customer();
        $reflection = new \ReflectionClass($customer);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($customer, 1);

        $this->assertSame(1, $customer->getId());
    }

    public function testGetAndSetName()
    {
        $customer = new Customer();
        $customer->setName('John');
        $this->assertSame('John', $customer->getName());
    }

    public function testGetAndSetSurname()
    {
        $customer = new Customer();
        $customer->setSurname('Doe');
        $this->assertSame('Doe', $customer->getSurname());
    }

    public function testGetAndSetPhone()
    {
        $customer = new Customer();
        $customer->setPhone('1234567890');
        $this->assertSame('1234567890', $customer->getPhone());
    }

    public function testGetAndSetEmail()
    {
        $customer = new Customer();
        $customer->setEmail('john.doe@example.com');
        $this->assertSame('john.doe@example.com', $customer->getEmail());
    }

    public function testSetAndGetPassword()
    {
        $customer = new Customer();
        $customer->setPassword('plain_password');
        $this->assertSame('plain_password', $customer->getPassword());
    }
}
