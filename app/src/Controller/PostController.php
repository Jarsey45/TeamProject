<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController {
	#[Route('/api/post', name: 'api_post_add', methods: ['POST'])]
	public function addPost(
		Request $request,
		EntityManagerInterface $entityManager,
		PostRepository $postRepository,
		UserRepository $userRepository
	) : Response {
		$this->denyAccessUnlessGranted('ROLE_USER');

		try {
			$content = $request->request->get('content');

			if (!$content) {
				throw new \Exception('Post content cannot be empty');
			}

			$post = new Post();
			$post->setContent($content)->setAuthor($this->getUser());

			$entityManager->persist($post);
			$entityManager->flush();

			$this->addFlash('success', 'Post created!');
		} catch (\Exception $e) {
			$this->addFlash('error', 'An error occurred: ' . $e->getMessage());
		}

		// Pobierz listę postów i użytkowników online
		$posts = $postRepository->findAllSortedByUpdatedAt();
		$users = $userRepository->findAll();

		return $this->render('index.html.twig', [
			'posts' => $posts,
			'online_users' => $this->getOnlineUsers(),
			'users' => $users, // Dodajemy brakującą zmienną
		]);
	}

	#[Route('/post/{id}', name: 'post_get', methods: ['GET'])]
	public function getPost(Post $post) : Response {
		return $this->render('post/index.html.twig', [
			'post' => $post,
			'comments' => $post->getComments(),
			'online_users' => $this->getOnlineUsers(),
		]);
	}

	private function getOnlineUsers() : array {
		return [
			['name' => 'User 1', 'status' => 'online'],
			['name' => 'User 2', 'status' => 'online'],
		];
	}
}
