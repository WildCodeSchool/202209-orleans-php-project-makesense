<?php

namespace App\Service;

use DateTime;
use App\Entity\Decision;

class TimelineManager
{
    public function getDecisionStatus(Decision $decision): ?string
    {
        $decisionStatus = '';

        /** @var DateTime */
        $now = new Datetime('now');
        if (
            $now >= $decision->getDecisionStartTime()
            && $now < $decision->getFirstDecisionEndDate()
        ) {
            $decisionStatus = Decision::FIRST_DECISION;
        } elseif (
            $now >= $decision->getConflictEndDate()
            && $now < $decision->getFinalDecisionEndDate()
        ) {
            $decisionStatus = Decision::FINAL_DECISION;
        }
        return $decisionStatus;
    }
}
