<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post {
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 255)]
	private ?string $userId = null;
	
	#[ORM\Column(length: 255, nullable: true)]
	private ?string $title = null;

	#[ORM\Column(length: 255)]
	private ?string $content = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $media = null;

	#[ORM\Column]
	private ?\DateTimeImmutable $createdAt = null;

	#[ORM\Column]
	private ?\DateTimeImmutable $updatedAt = null;

	#[ORM\Column(nullable: true)]
	private ?bool $isPublished = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $slug = null;

	#[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'posts')]
  private User $author;

	//TODO: Add relation to Comment

	public function getId() : ?int {
		return $this->id;
	}

	public function getAuthor() : ?string {
		return $this->author;
	}

	public function setAuthor(string $author) : static {
		$this->author = $author;

		return $this;
	}

	public function getTitle() : ?string {
		return $this->title;
	}

	public function setTitle(?string $title) : static {
		$this->title = $title;

		return $this;
	}

	public function getContent() : ?string {
		return $this->content;
	}

	public function setContent(string $content) : static {
		$this->content = $content;

		return $this;
	}

	public function getMedia() : ?string {
		return $this->media;
	}

	public function setMedia(?string $media) : static {
		$this->media = $media;

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

	public function isPublished() : ?bool {
		return $this->isPublished;
	}

	public function setPublished(?bool $isPublished) : static {
		$this->isPublished = $isPublished;

		return $this;
	}

	public function getSlug() : ?string {
		return $this->slug;
	}

	public function setSlug(?string $slug) : static {
		$this->slug = $slug;

		return $this;
	}
}
