<?php

namespace App\Entity;

use App\Repository\TagPostRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TagPostRepository::class)
 */
class TagPost
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Tag::class, inversedBy="tagPosts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tag;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="tagPosts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    public function setTag(?Tag $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }
}
