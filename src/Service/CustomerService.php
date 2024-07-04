<?php

namespace App\Service;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CustomerService
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    public function createCustomer(string $name, string $surname, string $phone, string $email, string $plainPassword): Customer
    {
        $customer = new Customer();
        $customer->setName($name)
            ->setSurname($surname)
            ->setPhone($phone)
            ->setEmail($email);
        
        $hashedPassword = $this->passwordHasher->hashPassword($customer, $plainPassword);
        $customer->setPassword($hashedPassword);

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        return $customer;
    }
}
