<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post {
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $title = null;

	#[ORM\Column(length: 255)]
	private ?string $content = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $media = null;

	#[ORM\Column(nullable: true)]
	private ?bool $isPublished = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $slug = null;

	#[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'posts')]
	#[ORM\JoinColumn(nullable: false)]
	private ?User $author = null;

	#[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'post')]
	private Collection $comments;

	#[ORM\OneToMany(targetEntity: Likes::class, mappedBy: 'post', orphanRemoval: true)]
	private Collection $likes;

	#[ORM\Column]
	private ?\DateTimeImmutable $createdAt = null;

	#[ORM\Column]
	private ?\DateTimeImmutable $updatedAt = null;

	public function __construct() {
		$this->createdAt = new \DateTimeImmutable();
		$this->updatedAt = new \DateTimeImmutable();
		$this->posts = new ArrayCollection();
		$this->likes = new ArrayCollection();
	}

	public function getId() : ?int {
		return $this->id;
	}

	public function getAuthor() : ?User {
		return $this->author;
	}

	public function setAuthor(?User $author) : static {
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

	public function getComments() : PersistentCollection {
		return $this->comments;
	}

	public function addComment(Comment $comment) {
		if (!$this->comments->contains($comment)) {
			$this->comments->add($comment);
			$comment->setPost($this);
		}

		return $this;
	}

	public function getLikes() : Collection {
		return $this->likes;
	}

	public function getLikesCount() : int {
		return $this->likes->count();
	}

	public function isLikedByUser(User $user) : bool {
		foreach ($this->likes as $like) {
			if ($like->getUser() === $user) {
				return true;
			}
		}
		return false;
	}

	public function addLike(Likes $like) : self {
		if (!$this->likes->contains($like)) {
			$this->likes->add($like);
			$like->setPost($this);
		}
		return $this;
	}

	public function removeLike(Likes $like) : self {
		if ($this->likes->removeElement($like)) {
			if ($like->getPost() === $this) {
				$like->setPost(null);
			}
		}
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
