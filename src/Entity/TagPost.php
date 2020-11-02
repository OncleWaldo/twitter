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
    private $tagId;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="tagPosts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $postId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTagId(): ?Tag
    {
        return $this->tagId;
    }

    public function setTagId(?Tag $tagId): self
    {
        $this->tagId = $tagId;

        return $this;
    }

    public function getPostId(): ?Post
    {
        return $this->postId;
    }

    public function setPostId(?Post $postId): self
    {
        $this->postId = $postId;

        return $this;
    }
}
