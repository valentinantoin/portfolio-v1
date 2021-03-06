<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 * @UniqueEntity(
 *     fields = {"username"},
 *     message = "Ce pseudo est déjà pris..."
 * )
 */
class Users implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(min = "6", minMessage= "Votre mot de passe doit faire 6 caractères minimum" )
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath= "password", message= "Votre mot de passe ne correspond pas")
     */
    private $password_check;

    /**
     * @ORM\Column(type="date")
     */
    private $creationDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comments", mappedBy="username", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProjectLike", mappedBy="user", orphanRemoval=true)
     */
    private $likes;

    /**
     * Users constructor.
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return Users
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMail(): ?string
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     * @return Users
     */
    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return Users
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPasswordCheck()
    {
        return $this->password_check;
    }

    /**
     * @param mixed $password_check
     */
    public function setPasswordCheck($password_check): void
    {
        $this->password_check = $password_check;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    /**
     * @param \DateTimeInterface $creationDate
     * @return Users
     */
    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     *
     */
    public function eraseCredentials() {}

    /**
     *
     */
    public function getSalt(){}

    /**
     * @return array
     */
    public function getRoles() {

        if($this->getId() <= 2){

            return ['ROLE_ADMIN'];

        }else {

            return ['ROLE_USER'];

        }
    }

    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * @param Comments $comment
     * @return Users
     */
    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUsername($this);
        }

        return $this;
    }

    /**
     * @param Comments $comment
     * @return Users
     */
    public function removeComment(Comments $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUsername() === $this) {
                $comment->setUsername(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProjectLike[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    /**
     * @param ProjectLike $like
     * @return Users
     */
    public function addLike(ProjectLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setUser($this);
        }

        return $this;
    }

    /**
     * @param ProjectLike $like
     * @return Users
     */
    public function removeLike(ProjectLike $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getUser() === $this) {
                $like->setUser(null);
            }
        }

        return $this;
    }
}

