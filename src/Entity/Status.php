<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    public const DECISION_NOT_STARTED = 'Non commencée';
    public const FIRST_DECISION = 'Première décision';
    public const CONFLICT_PERIOD = 'Période de conflit';
    public const FINAL_DECISION = 'Décision finale';
    public const DECISION_FINISHED = 'Décision terminée';
    public const STATUS_COLORS =
    [
        self::DECISION_NOT_STARTED => '#4fa5c4',
        self::FIRST_DECISION => '#3B8AA6',
        self::CONFLICT_PERIOD => '#2C7A88',
        self::FINAL_DECISION => '#1F5562',
        self::DECISION_FINISHED => '#0D3944',

    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $decisionStatus = null;

    #[ORM\Column(length: 7, nullable: true, options: [
        "fixed" => true,
    ])]
    private ?string $statusColor = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $statusDaysLeft = null;

    #[ORM\OneToOne(inversedBy: 'status', cascade: ['persist', 'remove'])]
    private ?Decision $decision = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDecisionStatus(): ?string
    {
        return $this->decisionStatus;
    }

    public function setDecisionStatus(?string $decisionStatus): self
    {
        $this->decisionStatus = $decisionStatus;

        return $this;
    }

    public function getStatusColor(): ?string
    {
        return $this->statusColor;
    }

    public function setStatusColor(?string $statusColor): self
    {
        $this->statusColor = $statusColor;

        return $this;
    }

    public function getStatusDaysLeft(): ?string
    {
        return $this->statusDaysLeft;
    }

    public function setStatusDaysLeft(?string $statusDaysLeft): self
    {
        $this->statusDaysLeft = $statusDaysLeft;

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
}
