<?php

namespace App\Service;

use DateTime;
use App\Entity\Status;
use App\Entity\Decision;

class TimelineManager
{
    public function checkDecisionStatus(Decision $decision): ?string
    {
        $decisionStatus = '';
        /** @var DateTime */
        $now = new Datetime('now');
        if ($now < $decision->getDecisionStartTime()) {
            $decisionStatus = Status::DECISION_NOT_STARTED;
        } elseif (
            $now >= $decision->getDecisionStartTime()
            && $now < $decision->getFirstDecisionEndDate()
        ) {
            $decisionStatus = Status::FIRST_DECISION;
        } elseif (
            $now >= $decision->getFirstDecisionEndDate()
            && $now < $decision->getConflictEndDate()
        ) {
            $decisionStatus = Status::CONFLICT_PERIOD;
        } elseif (
            $now >= $decision->getConflictEndDate()
            && $now < $decision->getFinalDecisionEndDate()
        ) {
            $decisionStatus = Status::FINAL_DECISION;
        } elseif ($now >= $decision->getFinalDecisionEndDate()) {
            $decisionStatus = Status::DECISION_FINISHED;
        }
        return $decisionStatus;
    }

    public function getStatusDaysLeft(Decision $decision): ?string
    {
        /** @var DateTime */
        $now = new Datetime('now');
        if ($this->checkDecisionStatus($decision) === Status::DECISION_NOT_STARTED) {
            $statusDate = $decision->getDecisionStartTime();
            $interval = date_diff($now, $statusDate, true);

            return $interval->format('%a jours restant(s)');
        } elseif ($this->checkDecisionStatus($decision) === Status::FIRST_DECISION) {
            $statusDate = $decision->getFirstDecisionEndDate();
            $interval = date_diff($now, $statusDate, true);

            return $interval->format('%a jours restant(s)');
        } elseif ($this->checkDecisionStatus($decision) === Status::CONFLICT_PERIOD) {
            $statusDate = $decision->getConflictEndDate();
            $interval = date_diff($now, $statusDate, true);

            return $interval->format('%a jours restant(s)');
        } elseif ($this->checkDecisionStatus($decision) === Status::FINAL_DECISION) {
            $statusDate = $decision->getFinalDecisionEndDate();
            $interval = date_diff($now, $statusDate, true);

            return $interval->format('%a jours restant(s)');
        } else {
            return null;
        }
    }
}
