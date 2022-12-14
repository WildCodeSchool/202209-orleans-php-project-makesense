<?php

namespace App\Entity;

use App\Repository\DecisionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DecisionRepository::class)]
class Decision
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $decisionStartTime = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $details = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $impact = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $gain = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $risk = null;

    #[ORM\Column]
    private ?int $creator = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $firstDecision = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $firstDecisionEndDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $conflictEndDate = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $finalDecision = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $finalDecisionEndDate = null;

    #[ORM\Column]
    private ?bool $isFinished = null;

    #[ORM\Column]
    private ?bool $isAbandonned = null;

    #[ORM\Column]
    private ?bool $isLate = null;

    #[ORM\Column(nullable: true)]
    private ?int $categoryId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDecisionStartTime(): ?\DateTimeInterface
    {
        return $this->decisionStartTime;
    }

    public function setDecisionStartTime(\DateTimeInterface $decisionStartTime): self
    {
        $this->decisionStartTime = $decisionStartTime;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getImpact(): ?string
    {
        return $this->impact;
    }

    public function setImpact(string $impact): self
    {
        $this->impact = $impact;

        return $this;
    }

    public function getGain(): ?string
    {
        return $this->gain;
    }

    public function setGain(string $gain): self
    {
        $this->gain = $gain;

        return $this;
    }

    public function getRisk(): ?string
    {
        return $this->risk;
    }

    public function setRisk(string $risk): self
    {
        $this->risk = $risk;

        return $this;
    }

    public function getCreator(): ?int
    {
        return $this->creator;
    }

    public function setCreator(int $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    public function getFirstDecision(): ?string
    {
        return $this->firstDecision;
    }

    public function setFirstDecision(?string $firstDecision): self
    {
        $this->firstDecision = $firstDecision;

        return $this;
    }

    public function getFirstDecisionEndDate(): ?\DateTimeInterface
    {
        return $this->firstDecisionEndDate;
    }

    public function setFirstDecisionEndDate(?\DateTimeInterface $firstDecisionEndDate): self
    {
        $this->firstDecisionEndDate = $firstDecisionEndDate;

        return $this;
    }

    public function getConflictEndDate(): ?\DateTimeInterface
    {
        return $this->conflictEndDate;
    }

    public function setConflictEndDate(?\DateTimeInterface $conflictEndDate): self
    {
        $this->conflictEndDate = $conflictEndDate;

        return $this;
    }

    public function getFinalDecision(): ?string
    {
        return $this->finalDecision;
    }

    public function setFinalDecision(?string $finalDecision): self
    {
        $this->finalDecision = $finalDecision;

        return $this;
    }

    public function getFinalDecisionEndDate(): ?\DateTimeInterface
    {
        return $this->finalDecisionEndDate;
    }

    public function setFinalDecisionEndDate(?\DateTimeInterface $finalDecisionEndDate): self
    {
        $this->finalDecisionEndDate = $finalDecisionEndDate;

        return $this;
    }

    public function isIsFinished(): ?bool
    {
        return $this->isFinished;
    }

    public function setIsFinished(bool $isFinished): self
    {
        $this->isFinished = $isFinished;

        return $this;
    }

    public function isIsAbandonned(): ?bool
    {
        return $this->isAbandonned;
    }

    public function setIsAbandonned(bool $isAbandonned): self
    {
        $this->isAbandonned = $isAbandonned;

        return $this;
    }

    public function isIsLate(): ?bool
    {
        return $this->isLate;
    }

    public function setIsLate(bool $isLate): self
    {
        $this->isLate = $isLate;

        return $this;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function setCategoryId(?int $categoryId): self
    {
        $this->categoryId = $categoryId;

        return $this;
    }
}
