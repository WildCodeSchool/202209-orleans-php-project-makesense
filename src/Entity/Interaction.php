<?php

namespace App\Entity;

use App\Repository\InteractionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InteractionRepository::class)]
class Interaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'interactions')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'interactions')]
    private ?Decision $decision = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $decisionRole = null;

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
        $this->decisionRole = $decisionRole;

        return $this;
    }
}
