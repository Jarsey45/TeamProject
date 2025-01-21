<?php
// src/Controller/Trait/CommonDataTrait.php

namespace App\Controller\Trait;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

trait CommonDataTrait
{
    private function getCommonData(EntityManagerInterface $entityManager): array
    {
        $users = $entityManager->getRepository(User::class)->findAll();

        // Mocked data for demonstration - you might want to implement actual online users logic
        $onlineUsers = 256;

        return [
            'online_users' => $onlineUsers,
            'users' => $users,
        ];
    }
}
