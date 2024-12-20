<?php
// src/Controller/RegisterController.php
namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use App\Entity\User;

class RegisterController extends AbstractController {
	#[Route('/register', name: 'app_register', methods: ['GET'])]
	public function show() : Response {
		return $this->render('security/register.html.twig', [
			'title' => 'Register',
		]);
	}

	#[Route('/register/new', name: 'app_register_new', methods: ['POST'])]
	public function index(
		Request $request,
		UserPasswordHasherInterface $passwordHasher,
		EntityManagerInterface $entityManager,
		ValidatorInterface $validator
	) : Response {
		try {

			$user = new User();

			$form = $request->request;

			$username = $form->get('username');
			$email = $form->get('email');
			$plaintextPassword = $form->get('password');
			$confirmPlaintextPassword = $form->get('confirm_password');

			if ($plaintextPassword !== $confirmPlaintextPassword) {
				$this->addFlash('error', 'Passwords do not match');
				return $this->redirectToRoute('app_register');
			}

			$hashedPassword = $passwordHasher->hashPassword(
				$user,
				$plaintextPassword
			);

			$user
				->setEmail($email)
				->setFirstName($username)
				->setPassword($hashedPassword)
				->setRoles(['ROLE_USER']); // TODO: should get default user from RolesRepository


			$errors = $validator->validate($user);
			if (count($errors) > 0) {
				throw new \InvalidArgumentException((string) $errors);
			}

			try {
				$entityManager->beginTransaction();
				// Save user to database
				$entityManager->persist($user);
				$entityManager->flush();
				$entityManager->commit();

				$this->addFlash('success', 'Registration successful! Please log in.');
				return $this->redirectToRoute('app_login');

			} catch (\Exception $e) {
				$entityManager->rollback();
				throw $e;
			}
		} catch (\InvalidArgumentException $e) {
			$this->addFlash('error', $e->getMessage());
			return $this->redirectToRoute('app_register');
		} catch (\Exception $e) {
			$this->addFlash('error', 'An unexpected error occurred during registration.');
			return $this->redirectToRoute('app_register');
		}
	}
}
