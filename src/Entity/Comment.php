<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentRepository;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $comment = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $commentTimedate = null;

    #[ORM\ManyToOne(inversedBy: 'comment', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Interaction $interaction = null;

    public function __construct()
    {
        $this->commentTimedate = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCommentTimedate(): ?\DateTimeInterface
    {
        return $this->commentTimedate;
    }

    public function setCommentTimedate(\DateTimeInterface $commentTimedate): self
    {
        $this->commentTimedate = $commentTimedate;

        return $this;
    }

    public function getInteraction(): ?Interaction
    {
        return $this->interaction;
    }

    public function setInteraction(?Interaction $interaction): self
    {
        $this->interaction = $interaction;

        return $this;
    }
}
