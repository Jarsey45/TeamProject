<?php
// src/Controller/RegisterController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;

class RegisterController extends AbstractController {
	#[Route('/register', name: 'app_register')]
	public function show() : Response {
		return $this->render('security/register.html.twig');
	}

	public function registerNewUser(UserPasswordHasherInterface $passwordHasher) : Response {
		$user = new User();

		// TODO: create new user

		return new Response('Created new user');
	}
}
