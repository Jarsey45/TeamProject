<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment {
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 255)]
	private ?string $content = null;

	#[ORM\ManyToOne(targetEntity: Post::class, inversedBy: 'comments')]
	#[ORM\JoinColumn(nullable: false)]
	private ?Post $post = null;

	#[ORM\ManyToOne(targetEntity: Comment::class)]
	#[ORM\JoinColumn(nullable: true)]
	private ?Comment $parentComment = null;

	#[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'comments')]
	#[ORM\JoinColumn(nullable: false)]
	private ?User $author = null;

	#[ORM\Column]
	private ?\DateTimeImmutable $createdAt = null;

	#[ORM\Column]
	private ?\DateTimeImmutable $updatedAt = null;

	public function __construct() {
		$this->createdAt = new \DateTimeImmutable();
		$this->updatedAt = new \DateTimeImmutable();
	}

	public function getId() : ?int {
		return $this->id;
	}

	public function setId(int $id) : static {
		$this->id = $id;

		return $this;
	}

	public function getContent() : ?string {
		return $this->content;
	}

	public function setContent(string $content) : static {
		$this->content = $content;

		return $this;
	}

	public function getAuthor() : ?User {
		return $this->author;
	}

	public function setAuthor(User $author) : static {
		$this->author = $author;

		return $this;
	}

	public function getPost() : ?Post {
		return $this->post;
	}

	public function setPost(Post $post) : static {
		$this->post = $post;

		return $this;
	}

	public function getParentComment() : ?Comment {
		return $this->parentComment;
	}

	public function setParentComment(?Comment $parentComment) : static {
		$this->parentComment = $parentComment;

		return $this;
	}

	public function getCreatedAt() : ?\DateTimeImmutable {
		return $this->createdAt;
	}

	public function setCreatedAt(\DateTimeImmutable $createdAt) : static {
		$this->createdAt = $createdAt;

		return $this;
	}

	public function getUpdatedAt() : ?\DateTimeImmutable {
		return $this->updatedAt;
	}

	public function setUpdatedAt(\DateTimeImmutable $updatedAt) : static {
		$this->updatedAt = $updatedAt;

		return $this;
	}
}
