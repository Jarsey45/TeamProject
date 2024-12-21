<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;

class FeedController extends AbstractController {

	#[Route('/api/posts', name: 'api_posts_list', methods: ['GET'])]
	public function getPosts(Request $request, PostRepository $postRepository) : Response {
		$page = $request->query->getInt('offset', 1);
		$limit = $request->query->getInt('limit', 10);

		$posts = $postRepository->getPostsForInifniteScroll($page, $limit);

		$json = [];

		foreach($posts as $post) {
			$json[] = $this->render('components/_post_card.html.twig', [
				'post' => $post
			]);
		}

		return $this->json($json);

	}
}
