<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController {
	#[Route('/api/post/{id}/comment', name: 'api_comment_add', methods: ['POST'])]
	public function addComment(
		Request $request,
		int $id,
		EntityManagerInterface $entityManager,
		PostRepository $postRepository
	) : Response {
		$this->denyAccessUnlessGranted('ROLE_USER');

		try {
			$post = $postRepository->find($id);

			if (!$post) {
				throw new \Exception('Post not found');
			}

			$content = $request->request->get('content');

			if (empty($content)) {
				throw new \Exception('Comment content cannot be empty');
			}

			$comment = new Comment();
			$comment
				->setContent($content)
				->setPost($post)
				->setAuthor($this->getUser());

			$entityManager->persist($comment);
			$entityManager->flush();

			$this->addFlash('success', 'Comment has been added!');
		} catch (\Exception $e) {
			$this->addFlash('error', 'An error occurred while creating comment: ' . $e->getMessage());
		}

		return $this->redirectToRoute('app_home');
	}

	private function getOnlineUsers() : array {
		return [
			['name' => 'User 1', 'status' => 'online'],
			['name' => 'User 2', 'status' => 'online'],
		];
	}
}
