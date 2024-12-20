<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LuckyController extends AbstractController {

	#[Route('/lucky/number')]
	public function number(EntityManagerInterface $entityManager) : Response {
		$number = random_int(0, 100);
		$user = $entityManager->getRepository(User::class)->find(1);

		return $this->render('lucky/number.html.twig', [
			'number' => $number,
			'userTest' => $user->getPosts(),
		]);
	}
}
