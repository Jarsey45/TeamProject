<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FeedController extends AbstractController {

	#[Route('/api/posts', name: 'api_posts_list', methods: ['GET'])]
	public function getPosts(PostRepository $postRepository): Response {
		$posts = $postRepository->findBy([], ['createdAt' => 'DESC']); // Pobierz posty według daty

		return $this->render('index.html.twig', [
			'posts' => $posts,
			'online_users' => $this->getOnlineUsers(),
		]);
	}
}
