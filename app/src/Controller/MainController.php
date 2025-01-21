<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class MainController extends AbstractController {

	#[Route('/dashboard', name: 'app_home')]
	#[Template('index.html.twig')]
	public function index(EntityManagerInterface $entityManager) : Response {

		$this->denyAccessUnlessGranted('ROLE_USER');

		$posts = $entityManager->getRepository(Post::class)->getPostsWithOffset(1, 5);
		$users = $entityManager->getRepository(User::class)->findAll();


		// Mocked data for demonstration
		$onlineUsers = 256;

		/**
		 * @var User[] $users
		 * @var Post[] $posts
		 * @var int $onlineUsers
		 */
		return $this->render('index.html.twig', [
			'online_users' => $onlineUsers,
			'users' => $users,
			'posts' => $posts,
		]);
	}
}
