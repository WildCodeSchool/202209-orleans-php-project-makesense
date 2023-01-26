<?php

namespace App\Entity;

use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\InteractionRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InteractionRepository::class)]
class Interaction
{
    public const DECISION_IMPACTED = 'impacté';
    public const DECISION_EXPERT = 'expert';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'interactions')]
    #[Assert\NotBlank(
        message: 'Le champ est obligatoire.'
    )]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'interactions')]
    #[Assert\NotBlank(
        message: 'Le champ est obligatoire.'
    )]
    private ?Decision $decision = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $decisionRole = null;

    #[ORM\Column(nullable: true)]
    private ?bool $vote = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDecisionRole(): ?string
    {
        return $this->decisionRole;
    }

    public function setDecisionRole(?string $decisionRole): self
    {
        if ($decisionRole !== self::DECISION_IMPACTED && $decisionRole !== self::DECISION_EXPERT) {
            throw new InvalidArgumentException("Le rôle que vous attribuez n'existe pas");
        }

        $this->decisionRole = $decisionRole;

        return $this;
    }

    public function isVote(): ?bool
    {
        return $this->vote;
    }

    public function setVote(?bool $vote): self
    {
        $this->vote = $vote;

        return $this;
    }
}
