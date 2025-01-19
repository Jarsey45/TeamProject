<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\Index(columns: ['email'])]
#[ORM\Index(columns: ['uuid'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, PasswordUpgraderInterface {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(type: Types::GUID)]
	private ?string $uuid = null;

	#[ORM\Column(length: 255)]
	private ?string $first_name = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $last_name = null;

	#[ORM\Column(length: 255)]
	#[Assert\Email(
		message: 'The email {{ value }} is not a valid email.',
	)]
	private ?string $email = null;

	#[ORM\Column(length: 255)]
	#[Assert\NotCompromisedPassword]
	#[Assert\Length(
		min: 6,
		minMessage: 'Your password should be at least {{ limit }} characters',
	)]
	private ?string $password = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $phone_number = null;

	#[ORM\Column(type: Types::JSON)]
	private array $roles = [];

	#[ORM\Column]
	private ?\DateTimeImmutable $created_at = null;

	#[ORM\Column(nullable: true)]
	private ?\DateTimeImmutable $updated_at = null;

	#[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'author')]
	private Collection $posts;

	//TODO: Add relation to Comment

	public function __construct() {
		$this->uuid = uuid_create();
		$this->created_at = new \DateTimeImmutable();
		$this->posts = new ArrayCollection();
	}

	public function getId() : ?int {
		return $this->id;
	}

	public function getUuid() : ?string {
		return $this->uuid;
	}

	public function setUuid(string $uuid) : static {
		$this->uuid = $uuid;

		return $this;
	}

	public function getFirstName() : ?string {
		return $this->first_name;
	}

	public function setFirstName(string $first_name) : static {
		$this->first_name = $first_name;

		return $this;
	}

	public function getLastName() : ?string {
		return $this->last_name;
	}

	public function setLastName(string $last_name) : static {
		$this->last_name = $last_name;

		return $this;
	}

	public function getEmail() : ?string {
		return $this->email;
	}

	public function setEmail(string $email) : static {
		$this->email = $email;

		return $this;
	}

	public function getPassword() : ?string {
		return $this->password;
	}

	public function setPassword(string $password) : static {
		$this->password = $password;

		return $this;
	}

	public function getPhoneNumber() : ?string {
		return $this->phone_number;
	}

	public function setPhoneNumber(string $phone_number) : static {
		$this->phone_number = $phone_number;

		return $this;
	}

	public function getRoles() : array {
		$roles = $this->roles;
		// guarantee every user at least has ROLE_USER
		$roles[] = 'ROLE_USER';

		return array_unique($roles);
	}

	public function setRoles(array $roles) : self {
		$this->roles = $roles;

		return $this;
	}

	public function getCreatedAt() : ?\DateTimeImmutable {
		return $this->created_at;
	}

	public function setCreatedAt(\DateTimeImmutable $created_at) : static {
		$this->created_at = $created_at;

		return $this;
	}

	public function getUpdatedAt() : ?\DateTimeImmutable {
		return $this->updated_at;
	}

	public function setUpdatedAt(?\DateTimeImmutable $updated_at) : static {
		$this->updated_at = $updated_at;

		return $this;
	}

	public function getPosts() : PersistentCollection {
		return $this->posts;
	}

	public function addPost(Post $post) {
		if (!$this->posts->contains($post)) {
			$this->posts->add($post);
			$post->setAuthor($this);
		}

		return $this;
	}

	public function removePost(Post $post) : static {
		if ($this->posts->removeElement($post)) {
			// Set the author to null if it was this user
			if ($post->getAuthor() === $this) {
				$post->setAuthor(null);
			}
		}

		return $this;
	}
	public function getUserIdentifier() : string {
		return (string) $this->email;
	}

	public function eraseCredentials() : void {

	}

	/**
	 * Used to upgrade (rehash) the user's password automatically over time.
	 */
	public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword) : void {
		if (!$user instanceof self) {
			throw new \InvalidArgumentException('Invalid user type.');
		}

		$user->setPassword($newHashedPassword);
		// Don't forget to update the updated_at timestamp if you want to track password changes
		$user->setUpdatedAt(new \DateTimeImmutable());
	}
}
