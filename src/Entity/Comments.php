<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentsRepository")
 */
class Comments
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Projects", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $projectId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $username;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Projects|null
     */
    public function getProjectId(): ?Projects
    {
        return $this->projectId;
    }

    /**
     * @param Projects|null $projectId
     * @return Comments
     */
    public function setProjectId(?Projects $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * @return Users|null
     */
    public function getUsername(): ?Users
    {
        return $this->username;
    }

    /**
     * @param Users|null $username
     * @return Comments
     */
    public function setUsername(?Users $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Comments
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
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
     * @return Comments
     */
    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }
}
