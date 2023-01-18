<?php

namespace App\Entity;

use App\Repository\DecisionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $firstDecisionEndDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $conflictEndDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $finalDecisionEndDate = null;

    #[ORM\ManyToOne(inversedBy: 'decisions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $creator = null;

    #[ORM\OneToMany(mappedBy: 'decision', targetEntity: Interaction::class)]
    private Collection $interactions;

    public function __construct()
    {
        $this->interactions = new ArrayCollection();
    }

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

    public function getFinalDecisionEndDate(): ?\DateTimeInterface
    {
        return $this->finalDecisionEndDate;
    }

    public function setFinalDecisionEndDate(?\DateTimeInterface $finalDecisionEndDate): self
    {
        $this->finalDecisionEndDate = $finalDecisionEndDate;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * @return Collection<int, Interaction>
     */
    public function getInteractions(): Collection
    {
        return $this->interactions;
    }

    public function addInteraction(Interaction $interaction): self
    {
        if (!$this->interactions->contains($interaction)) {
            $this->interactions->add($interaction);
            $interaction->setDecision($this);
        }

        return $this;
    }

    public function removeInteraction(Interaction $interaction): self
    {
        if ($this->interactions->removeElement($interaction)) {
            // set the owning side to null (unless already changed)
            if ($interaction->getDecision() === $this) {
                $interaction->setDecision(null);
            }
        }

        return $this;
    }
}
