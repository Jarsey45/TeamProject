<?php

namespace App\Controller;

use App\Controller\Trait\CommonDataTrait;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class UserController extends AbstractController {

	use CommonDataTrait;

	#[Route('/user/profile', name: 'user_profile')]
	#[Template('user/index.html.twig')]
	public function index(EntityManagerInterface $entityManager) : Response {

		$this->denyAccessUnlessGranted('ROLE_USER');


		$commonData = $this->getCommonData($entityManager);
		return $this->render(
				'user/index.html.twig',
				array_merge(
						$commonData,
						[
								'currentUser' => $this->getUser(),
						],
				)
		);
	}
}
