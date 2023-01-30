<?php

namespace App\Service;

use DateTime;
use App\Entity\Decision;

class TimelineManager
{
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
}
