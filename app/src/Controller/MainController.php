<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

use App\Controller\Trait\CommonDataTrait;

class MainController extends AbstractController {

	use CommonDataTrait;

	#[Route('/dashboard', name: 'app_home')]
	#[Template('index.html.twig')]
	public function index(EntityManagerInterface $entityManager) : Response {

		$this->denyAccessUnlessGranted('ROLE_USER');

		$posts = $entityManager->getRepository(Post::class)->findAllSortedByUpdatedAt();

		// Mocked data for demonstration
		$commonData = $this->getCommonData($entityManager);

		/**
		 * @var User[] $users
		 * @var Post[] $posts
		 * @var int $onlineUsers
		 */
		return $this->render('index.html.twig',
			array_merge(
				$commonData,
				[
					'posts' => $posts,
				]
			)
		);
	}
}
