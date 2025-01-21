<?php

namespace App\Controller;

use App\Controller\Trait\CommonDataTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Post;
use App\Entity\Comment;

class CommentController extends AbstractController {
	use CommonDataTrait;

	#[Route('/api/post/{id}/comment', name: 'api_comment_add', methods: ['POST'])]
	public function addComment(Request $request, int $id, EntityManagerInterface $entityManager) : Response {
		// Check if user is logged in
		$this->denyAccessUnlessGranted('ROLE_USER');

		try {
			$post = $entityManager->getRepository(Post::class)->find($id);

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
			$this->addFlash(
				'error',
				'An error occurred while creating comment: ' . $e->getMessage()
			);
		}

		return $this->redirectToRoute('post_get', ['id' => $id]);
	}
}
