<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(
        message: 'Le champ est obligatoire.'
    )]
    private ?string $comment = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $commentTimedate = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?Decision $decision = null;

    #[ORM\Column(nullable: true)]
    private ?bool $inConflict = null;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDecision(): ?Decision
    {
        return $this->decision;
    }

    public function setDecision(?Decision $decision): self
    {
        $this->decision = $decision;

        return $this;
    }

    public function isInConflict(): ?bool
    {
        return $this->inConflict;
    }

    public function setInConflict(?bool $inConflict): self
    {
        $this->inConflict = $inConflict;

        return $this;
    }
}
