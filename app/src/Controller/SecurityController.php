<?php
// src/Controller/SecurityController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController {
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response {
        // Sprawdzenie, czy użytkownik jest już zalogowany
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        // Pobranie błędu logowania, jeśli taki istnieje
        $error = $authenticationUtils->getLastAuthenticationError();

        // Ostatnia wprowadzona nazwa użytkownika
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void {
        // Wylogowanie jest obsługiwane przez Symfony, więc to miejsce nie powinno być wywoływane
        throw new \Exception('This should never be reached!');
    }
}
