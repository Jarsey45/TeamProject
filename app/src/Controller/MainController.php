<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // Mocked data for demonstration
        $onlineUsers = 256;
        $users = [
            ['name' => 'Super fisher'],
            ['name' => 'Pro fisher'],
            ['name' => 'Newbie fisher'],
        ];

        $posts = [
            ['author' => 'Super fisher', 'content' => 'Caught a record-breaking marlin today! 🎣 230 lbs of pure challenge. #FishingLife #RecordCatch'],
            ['author' => 'Pro fisher', 'content' => 'Just tried a new bait for bass, worked like magic! 🐟 Cant wait to share the details in my next vlog.'],
            ['author' => 'Newbie fisher', 'content' => 'First time fishing today! Didnt catch anything :('],
        ];

        return $this->render('index.html.twig', [
            'online_users' => $onlineUsers,
            'users' => $users,
            'posts' => $posts,
        ]);
    }
}
