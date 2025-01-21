<?php
namespace App\Entity;

use App\Repository\LikesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LikesRepository::class)]
#[ORM\Table(name: '`likes`')] // SQL reserved word, needs backticks
class Likes {
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\ManyToOne(targetEntity: User::class)]
	#[ORM\JoinColumn(nullable: false)]
	private ?User $user = null;

	#[ORM\ManyToOne(targetEntity: Post::class, inversedBy: 'likes')]
	#[ORM\JoinColumn(nullable: false)]
	private ?Post $post = null;

	#[ORM\Column]
	private ?\DateTimeImmutable $createdAt = null;

	public function __construct() {
		$this->createdAt = new \DateTimeImmutable();
	}

	// Getters and setters
	public function getId() : ?int {
		return $this->id;
	}

	public function getUser() : ?User {
		return $this->user;
	}

	public function setUser(?User $user) : static {
		$this->user = $user;
		return $this;
	}

	public function getPost() : ?Post {
		return $this->post;
	}

	public function setPost(?Post $post) : static {
		$this->post = $post;
		return $this;
	}

	public function getCreatedAt() : ?\DateTimeImmutable {
		return $this->createdAt;
	}
}
