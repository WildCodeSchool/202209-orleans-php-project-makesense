<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

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

    #[ORM\ManyToOne(inversedBy: 'comment')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Interaction $interaction = null;

    #[ORM\Column]
    private ?bool $isInConflict = null;

    #[ORM\Column(length: 7)]
    private ?string $conflictColor = null;

    #[ORM\Column(length: 7)]
    private ?string $commentColor = null;

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

    public function isIsInConflict(): ?bool
    {
        return $this->isInConflict;
    }

    public function setIsInConflict(bool $isInConflict): self
    {
        $this->isInConflict = $isInConflict;

        return $this;
    }

    public function getConflictColor(): ?string
    {
        return $this->conflictColor;
    }

    public function setConflictColor(string $conflictColor): self
    {
        $this->conflictColor = $conflictColor;

        return $this;
    }

    public function getCommentColor(): ?string
    {
        return $this->commentColor;
    }

    public function setCommentColor(string $commentColor): self
    {
        $this->commentColor = $commentColor;

        return $this;
    }
}
