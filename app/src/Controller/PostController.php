<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Post;

class PostController extends AbstractController {

	#[Route('/api/post', name: 'api_post_add', methods: ['POST'])]
	public function addPost(Request $request, EntityManagerInterface $entityManager) : Response {

		// check if user is logged in
		$this->denyAccessUnlessGranted('ROLE_USER');

		$currentUser = $this->getUser();


		$post = new Post();

		try {
			$form = $request->request;
			$content = $form->get('content');

			$post
				->setContent($content)
				->setAuthor($currentUser);

			$entityManager->persist($post);
			$entityManager->flush();

			// return the post

			$this->addFlash('success', 'Post has been created!');
			return $this->redirectToRoute('app_home');
		} catch (\Exception $e) {
			$this->addFlash('error', 'An error occurred while creating the post.');
			return $this->redirectToRoute('app_home');
		}

	}
}
