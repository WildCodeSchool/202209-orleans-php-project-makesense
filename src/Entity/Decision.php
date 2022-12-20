<?php

namespace App\Entity;

use App\Repository\DecisionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DecisionRepository::class)]
class Decision
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(
        message: 'Le champ est obligatoire.'
    )]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(
        message: 'Le champ est obligatoire.'
    )]
    private ?\DateTimeInterface $decisionStartTime = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(
        message: 'Le champ est obligatoire.'
    )]
    private ?string $details = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(
        message: 'Le champ est obligatoire.'
    )]
    private ?string $impact = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(
        message: 'Le champ est obligatoire.'
    )]
    private ?string $gain = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(
        message: 'Le champ est obligatoire.'
    )]
    private ?string $risk = null;

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
}
