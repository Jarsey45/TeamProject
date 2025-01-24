<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Likes;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController {
    #[Route('/api/post/{id}/like', name: 'api_post_like', methods: ['POST'])]
    public function toggleLike(
        Post $post,
        EntityManagerInterface $entityManager,
        PostRepository $postRepository,
        UserRepository $userRepository
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();

        $likeRepository = $entityManager->getRepository(Likes::class);
        $existingLike = $likeRepository->findOneBy([
            'post' => $post,
            'user' => $user,
        ]);

        if ($existingLike) {
            $entityManager->remove($existingLike);
        } else {
            $like = new Likes();
            $like->setPost($post)
                ->setUser($user);

            $entityManager->persist($like);
        }

        $entityManager->flush();

        $posts = $postRepository->findAllSortedByUpdatedAt();
        $users = $userRepository->findAll();

        return $this->render('index.html.twig', [
            'posts' => $posts,
            'online_users' => $this->getOnlineUsers(),
            'users' => $users,
        ]);
    }

    private function getOnlineUsers(): array {
        return [
            ['name' => 'User 1', 'status' => 'online'],
            ['name' => 'User 2', 'status' => 'online'],
        ];
    }
}
