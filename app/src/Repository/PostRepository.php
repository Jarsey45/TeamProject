<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 */
class PostRepository extends ServiceEntityRepository {
	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, Post::class);
	}

	public function getPostsWithOffset(int $offset = 1, int $limit = 5) : array {
		$offset = ($offset - 1) * $limit;

		$query = $this->createQueryBuilder('p')
			->orderBy('p.createdAt', 'DESC')
			->setFirstResult($offset)
			->setMaxResults($limit)
			->getQuery();

		return $query->getResult();
	}

	public function getPostsForInifniteScroll(int $offset = 1, int $limit = 10) : array {
		$query = $this->createQueryBuilder('p')
			->orderBy('p.createdAt', 'DESC')
			->setFirstResult($offset)
			->setMaxResults($limit)
			->getQuery();

		return $query->getResult();
	}
}
