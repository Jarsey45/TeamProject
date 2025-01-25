<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements UserLoaderInterface {
	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, User::class);
	}

	public function loadUserByIdentifier(string $email) : ?User {
		$entityManager = $this->getEntityManager();

		return $entityManager->createQuery(
			'SELECT u
			FROM App\Entity\User u
			WHERE u.email = :query'
		)
			->setParameter('query', $email)
			->getOneOrNullResult();
	}

}
