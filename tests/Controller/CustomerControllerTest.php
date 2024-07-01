<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;

class CustomerControllerTest extends WebTestCase
{
    private $client;
    private $entityManager;
    private $testCustomerId;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();

        // Clear existing data
        $this->entityManager->createQuery('DELETE FROM App\Entity\Customer')->execute();

        // Create a test customer
        $customer = new Customer();
        $customer->setName('Test User');
        $customer->setPhone('123456789');
        $customer->setEmail('test.user@example.com');
        $customer->setPassword('testpassword'); // Assuming the password is hashed

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        $this->testCustomerId = $customer->getId();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function testCreateCustomer()
    {
        $this->client->request(
            'POST',
            '/customers',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'name' => 'Jane Doe',
                'phone' => '987654321',
                'email' => 'jane.doe@example.com',
                'password' => 'securepassword'
            ])
        );

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
    }

    public function testGetCustomers()
    {
        $this->client->request('GET', '/customers');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testGetCustomer()
    {
        $this->client->request('GET', '/customers/' . $this->testCustomerId);

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testUpdateCustomer()
    {
        $this->client->request(
            'PUT',
            '/customers/' . $this->testCustomerId,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'name' => 'John Doe Updated',
                'phone' => '123456789',
                'email' => 'john.doe.updated@example.com',
                'password' => 'newsecurepassword'
            ])
        );

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testDeleteCustomer()
    {
        $this->client->request('DELETE', '/customers/' . $this->testCustomerId);

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }
}
