<?php

namespace App\Service;

use DateTime;
use DateInterval;
use App\Entity\Decision;

class AutomatedDates
{
    public function firstDecisionEndDateCalculation(Decision $decision): DateTime
    {
        $dateinterval = new DateInterval('P14D');
        /** @var DateTime */
        $firstDecisionEndDate = clone $decision->getDecisionStartTime();
        return $firstDecisionEndDate->add($dateinterval);
    }

    public function conflictEndDateCalculation(Decision $decision): DateTime
    {
        $dateinterval = new DateInterval('P14D');
        /** @var DateTime */
        $conflictEndDate = clone $decision->getFirstDecisionEndDate();
        return $conflictEndDate->add($dateinterval);
    }

    public function finalDecisionEndDateCalculation(Decision $decision): DateTime
    {
        $dateinterval = new DateInterval('P14D');
        /** @var DateTime */
        $finalDecisionEndDate = clone $decision->getConflictEndDate();
        return $finalDecisionEndDate->add($dateinterval);
    }
}
