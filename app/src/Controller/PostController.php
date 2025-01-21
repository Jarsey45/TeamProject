<?php

namespace App\Controller;

use App\Controller\Trait\CommonDataTrait;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Post;

class PostController extends AbstractController {

	use CommonDataTrait;

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

	#[Route('/post/{id}', name: 'post_get', methods: ['GET'])]
	#[Template('post/index.html.twig')]
	public function getPost(int $id, EntityManagerInterface $entityManager) : Response {
		try {
			$post = $entityManager->getRepository(Post::class)->find($id);

			if (!$post) {
				return $this->json([
					'error' => 'Post not found'
				], Response::HTTP_NOT_FOUND);
			}

			//this should definetly be more sophisticated approach
			//for now we will just return the post and its comments with trait
			$commonData = $this->getCommonData($entityManager);

			return $this->render(
				'post/index.html.twig',
				array_merge($commonData, [
					'post' => $post,
					'comments' => $post->getComments(),
				])
			);

		} catch (\Exception $e) {
			$this->addFlash('error', 'An error occurred while creating the post. ' . $e->getMessage());
			return $this->redirectToRoute('app_home');
		}
	}
}
