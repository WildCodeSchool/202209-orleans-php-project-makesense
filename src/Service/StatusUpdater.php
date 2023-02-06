<?php

namespace App\Service;

use App\Entity\Status;
use App\Entity\Decision;
use App\Repository\DecisionRepository;
use App\Repository\StatusRepository;

class StatusUpdater
{
    public function __construct(private StatusRepository $statusRepository, private TimelineManager $timelineManager)
    {
    }

    public function saveDecisionStatus(Decision $decision): void
    {
        if ($decision->getStatus()->getDecisionStatus() !== $this->timelineManager->checkDecisionStatus($decision)) {
            if ($decision->getStatus()) {
                $status = $decision->getStatus();
            } else {
                $status = new Status();
            }
            $status->setDecisionStatus($this->timelineManager->checkDecisionStatus($decision));
            $status->setStatusColor(Status::STATUS_COLORS[$status->getDecisionStatus()]);
            $status->setStatusDaysLeft($this->timelineManager->getStatusDaysLeft($decision));

            $status->setDecision($decision);
            $this->statusRepository->save($status, true);
        }
    }

    public function saveDecisionsStatus(array $decisions): void
    {
        foreach ($decisions as $decision) {
            if (
                $decision->getStatus()->getDecisionStatus() !==
                $this->timelineManager->checkDecisionStatus($decision)
            ) {
                if ($decision->getStatus()) {
                    $status = $decision->getStatus();
                } else {
                    $status = new Status();
                }
                $status->setDecisionStatus($this->timelineManager->checkDecisionStatus($decision));
                $status->setStatusColor(Status::STATUS_COLORS[$status->getDecisionStatus()]);
                $status->setStatusDaysLeft($this->timelineManager->getStatusDaysLeft($decision));

                $status->setDecision($decision);
                $this->statusRepository->save($status, true);
            }
        }
    }
}
