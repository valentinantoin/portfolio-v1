<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\User;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Entity\Users;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectsRepository")
 * @Vich\Uploadable()
 */
class Projects
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=100)
     * @var string|null
     */
    private $imageName;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="project_img", fileNameProperty="imageName")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comments", mappedBy="projectId", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProjectLike", mappedBy="Project")
     */
    private $Likes;

    /**
     * Projects constructor.
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->Likes = new ArrayCollection();
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
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Projects
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

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
     * @return Projects
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param string $link
     * @return Projects
     */
    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageName
     * @throws \Exception
     */
    public function setImageFile(File $imageName = null)
    {
        $this->imageFile = $imageName;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($imageName) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @param $image
     */
    public function setImageName($image)
    {
        $this->imageName = $image;
    }

    /**
     * @return string|null
     */
    public function getImageName()
    {
        return $this->imageName;
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
     * @return Projects
     */
    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setProjectId($this);
        }

        return $this;
    }

    /**
     * @param Comments $comment
     * @return Projects
     */
    public function removeComment(Comments $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getProjectId() === $this) {
                $comment->setProjectId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProjectLike[]
     */
    public function getLikes(): Collection
    {
        return $this->Likes;
    }

    /**
     * @param ProjectLike $like
     * @return Projects
     */
    public function addLike(ProjectLike $like): self
    {
        if (!$this->Likes->contains($like)) {
            $this->Likes[] = $like;
            $like->setProject($this);
        }

        return $this;
    }

    /**
     * @param ProjectLike $like
     * @return Projects
     */
    public function removeLike(ProjectLike $like): self
    {
        if ($this->Likes->contains($like)) {
            $this->Likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getProject() === $this) {
                $like->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @param \App\Entity\Users $user
     * @return bool
     */
    public function isLikedByUser(Users $user): bool
    {
        foreach ($this->Likes as $like)
        {
            if($like->getUser() === $user) return true;
        }

        return false;
    }
}
