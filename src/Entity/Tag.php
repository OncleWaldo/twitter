<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity=TagPost::class, mappedBy="tagId")
     */
    private $tagPosts;

    public function __construct()
    {
        $this->tagPosts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection|TagPost[]
     */
    public function getTagPosts(): Collection
    {
        return $this->tagPosts;
    }

    public function addTagPost(TagPost $tagPost): self
    {
        if (!$this->tagPosts->contains($tagPost)) {
            $this->tagPosts[] = $tagPost;
            $tagPost->setTagId($this);
        }

        return $this;
    }

    public function removeTagPost(TagPost $tagPost): self
    {
        if ($this->tagPosts->removeElement($tagPost)) {
            // set the owning side to null (unless already changed)
            if ($tagPost->getTagId() === $this) {
                $tagPost->setTagId(null);
            }
        }

        return $this;
    }
}
