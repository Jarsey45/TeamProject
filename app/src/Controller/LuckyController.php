<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LuckyController extends AbstractController {

	#[Route('/test')]
	public function number(EntityManagerInterface $entityManager) : Response {

		$user = $entityManager->getRepository(User::class)->find(7);
		$posts = $user->getPosts();
		$posts->initialize();

		return $this->render('lucky/number.html.twig', [
			'user' => $user,
			'posts' => $posts,
		]);
	}
}
