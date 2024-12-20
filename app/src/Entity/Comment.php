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
	private ?string $userId = null;

	#[ORM\Column(length: 255)]
	private ?string $content = null;

	#[ORM\Column]
	private ?int $post_id = null;

	#[ORM\Column(nullable: true)]
	private ?int $parent_id = null;

	#[ORM\Column]
	private ?\DateTimeImmutable $createdAt = null;

	#[ORM\Column]
	private ?\DateTimeImmutable $updatedAt = null;

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

	public function getAuthor() : ?string {
		return $this->author;
	}

	public function setAuthor(string $author) : static {
		$this->author = $author;

		return $this;
	}

	public function getPostId() : ?int {
		return $this->post_id;
	}

	public function setPostId(int $post_id) : static {
		$this->post_id = $post_id;

		return $this;
	}

	public function getParentComment() : ?int {
		return $this->parentComment;
	}

	public function setParentComment(?int $parentComment) : static {
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
		return $this->createdAt;
	}

	public function setUpdatedAt(\DateTimeImmutable $createdAt) : static {
		$this->createdAt = $createdAt;

		return $this;
	}
}
