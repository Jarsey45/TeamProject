<?php
// src/Controller/LikeController.php

namespace App\Controller;

use App\Entity\Likes;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController {
	#[Route('/api/post/{id}/like', name: 'api_post_like', methods: ['POST'])]
	public function toggleLike(Post $post, EntityManagerInterface $entityManager) : Response {
		$this->denyAccessUnlessGranted('ROLE_USER');
		$user = $this->getUser();

		$likeRepository = $entityManager->getRepository(Likes::class);
		$existingLike = $likeRepository->findOneBy([
			'post' => $post,
			'user' => $user
		]);

		if ($existingLike) {
			// Unlike
			$entityManager->remove($existingLike);
			$message = 'Post unliked successfully';
		} else {
			// Like
			$like = new Likes();
			$like->setPost($post)
				->setUser($user);

			$entityManager->persist($like);
			$message = 'Post liked successfully';
		}

		$entityManager->flush();

		// return $this->json(data: [
		// 	'success' => true,
		// 	'message' => $message,
		// 	'likesCount' => $post->getLikesCount(),
		// 	'isLiked' => $post->isLikedByUser($user)
		// ]);

		$this->addFlash('success', $message);
		return $this->redirectToRoute('post_get', ['id' => $post->getId()]);
	}
}
