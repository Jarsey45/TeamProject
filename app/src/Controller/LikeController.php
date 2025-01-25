<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Likes;
use App\Repository\LikesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController {
	#[Route('/api/post/{id}/like', name: 'api_post_like', methods: ['POST'])]
	public function toggleLike(
		Post $post,
		EntityManagerInterface $entityManager,
		LikesRepository $likeRepository,
	) : Response {
		$this->denyAccessUnlessGranted('ROLE_USER');
		$user = $this->getUser();

		try {
			$existingLike = $likeRepository->findOneBy([
				'post' => $post,
				'user' => $user,
			]);

			if ($existingLike) {
				$entityManager->remove($existingLike);
				$this->addFlash('success', 'Post Unliked');
			} else {
				$like = new Likes();
				$like->setPost($post)
					->setUser($user);

				$entityManager->persist($like);
				$this->addFlash('success', 'Post Liked');
			}

			$entityManager->flush();

		} catch (\Exception $e) {
			$this->addFlash('success', 'An error occured liking post');
		}



		return $this->redirectToRoute('app_home');
	}
}
