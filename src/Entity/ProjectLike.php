<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectLikeRepository")
 */
class ProjectLike
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Projects", inversedBy="Likes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Project;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="likes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?Projects
    {
        return $this->Project;
    }

    public function setProject(?Projects $Project): self
    {
        $this->Project = $Project;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }
}
