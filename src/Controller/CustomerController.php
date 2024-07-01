<?php

namespace App\Controller;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    #[Route('/customers', name: 'get_customers', methods: ['GET'])]
    public function getCustomers(EntityManagerInterface $em): JsonResponse
    {
        $customers = $em->getRepository(Customer::class)->findAll();
        return $this->json($customers);
    }

    #[Route('/customers/{id}', name: 'get_customer', methods: ['GET'])]
    public function getCustomer(int $id, EntityManagerInterface $em): JsonResponse
    {
        $customer = $em->getRepository(Customer::class)->find($id);
        if (!$customer) {
            return $this->json(['message' => 'Customer not found'], 404);
        }
        return $this->json($customer);
    }

    #[Route('/customers', name: 'create_customer', methods: ['POST'])]
    public function createCustomer(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $customer = new Customer();
        $customer->setName($data['name']);
        $customer->setPhone($data['phone']);
        $customer->setEmail($data['email']);
        $customer->setPassword($data['password']); // Note: Store hashed password in a real application

        $em->persist($customer);
        $em->flush();

        return $this->json($customer, 201);
    }

    #[Route('/customers/{id}', name: 'update_customer', methods: ['PUT', 'PATCH'])]
    public function updateCustomer(int $id, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $customer = $em->getRepository(Customer::class)->find($id);
        if (!$customer) {
            return $this->json(['message' => 'Customer not found'], 404);
        }

        $data = json_decode($request->getContent(), true);
        $customer->setName($data['name'] ?? $customer->getName());
        $customer->setPhone($data['phone'] ?? $customer->getPhone());
        $customer->setEmail($data['email'] ?? $customer->getEmail());
        $customer->setPassword($data['password'] ?? $customer->getPassword());

        $em->flush();

        return $this->json($customer);
    }

    #[Route('/customers/{id}', name: 'delete_customer', methods: ['DELETE'])]
    public function deleteCustomer(int $id, EntityManagerInterface $em): JsonResponse
    {
        $customer = $em->getRepository(Customer::class)->find($id);
        if (!$customer) {
            return $this->json(['message' => 'Customer not found'], 404);
        }

        $em->remove($customer);
        $em->flush();

        return $this->json(['message' => 'Customer deleted']);
    }
}
