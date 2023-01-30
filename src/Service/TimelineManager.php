<?php

namespace App\Service;

use DateTime;
use App\Entity\Decision;
use App\Repository\DecisionRepository;

class TimelineManager
{
    public function __construct(private DecisionRepository $decisionRepository)
    {
    }

    public function checkDecisionStatus(Decision $decision): ?string
    {
        $decisionStatus = '';
        /** @var DateTime */
        $now = new Datetime('now');
        if ($now < $decision->getDecisionStartTime()) {
            $decisionStatus = Decision::DECISION_NOT_STARTED;
        } elseif (
            $now >= $decision->getDecisionStartTime()
            && $now < $decision->getFirstDecisionEndDate()
        ) {
            $decisionStatus = Decision::FIRST_DECISION;
        } elseif (
            $now >= $decision->getFirstDecisionEndDate()
            && $now < $decision->getConflictEndDate()
        ) {
            $decisionStatus = Decision::CONFLICT_PERIOD;
        } elseif (
            $now >= $decision->getConflictEndDate()
            && $now < $decision->getFinalDecisionEndDate()
        ) {
            $decisionStatus = Decision::FINAL_DECISION;
        } elseif ($now >= $decision->getFinalDecisionEndDate()) {
            $decisionStatus = Decision::DECISION_FINISHED;
        }

        return $decisionStatus;
    }

    public function saveDecisionStatus(Decision $decision): void
    {
        if ($decision->getDecisionStatus() !== $this->checkDecisionStatus($decision)) {
            if ($this->checkDecisionStatus($decision) === Decision::DECISION_NOT_STARTED) {
                $decision->setDecisionStatus(Decision::DECISION_NOT_STARTED);
                $decision->setStatusColor(Decision::STATUS_COLORS[Decision::DECISION_NOT_STARTED]);
            } elseif ($this->checkDecisionStatus($decision) === Decision::FIRST_DECISION) {
                $decision->setDecisionStatus(Decision::FIRST_DECISION);
                $decision->setStatusColor(Decision::STATUS_COLORS[Decision::FIRST_DECISION]);
            } elseif ($this->checkDecisionStatus($decision) === Decision::CONFLICT_PERIOD) {
                $decision->setDecisionStatus(Decision::CONFLICT_PERIOD);
                $decision->setStatusColor(Decision::STATUS_COLORS[Decision::CONFLICT_PERIOD]);
            } elseif ($this->checkDecisionStatus($decision) === Decision::FINAL_DECISION) {
                $decision->setDecisionStatus(Decision::FINAL_DECISION);
                $decision->setStatusColor(Decision::STATUS_COLORS[Decision::FINAL_DECISION]);
            } elseif ($this->checkDecisionStatus($decision) === Decision::DECISION_FINISHED) {
                $decision->setDecisionStatus(Decision::DECISION_FINISHED);
                $decision->setStatusColor(Decision::STATUS_COLORS[Decision::DECISION_FINISHED]);
            }

            $this->decisionRepository->save($decision, true);
        }
    }

    public function saveDecisionsStatus(array $decisions): void
    {
        foreach ($decisions as $decision) {
            if ($decision->getDecisionStatus() !== $this->checkDecisionStatus($decision)) {
                $decision->setDecisionStatus($this->checkDecisionStatus($decision));
                $decision->setStatusColor(Decision::STATUS_COLORS[$this->checkDecisionStatus($decision)]);
                $this->decisionRepository->save($decision, true);
            }
        }
    }
}
