<?php

namespace App\Tests\Entity;

use App\Entity\Customer;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function testCustomerEntity()
    {
        $customer = new Customer();
        $customer->setName('John Doe');
        $customer->setPhone('123456789');
        $customer->setEmail('john.doe@example.com');
        $customer->setPassword('securepassword');

        $this->assertEquals('John Doe', $customer->getName());
        $this->assertEquals('123456789', $customer->getPhone());
        $this->assertEquals('john.doe@example.com', $customer->getEmail());
        $this->assertEquals('securepassword', $customer->getPassword());
    }
}
