<?php

namespace App\Service;

use App\Entity\Decision;

class DecisionVote
{
    public function countUpVotes(Decision $decision): int
    {
        $interactions = $decision->getInteractions();

        $upVotes = 0;
        foreach ($interactions as $interaction) {
            if ($interaction->isVote() === true) {
                $upVotes++;
            }
        }

        return $upVotes;
    }

    public function countDownVotes(Decision $decision): int
    {
        $interactions = $decision->getInteractions();

        $downVotes = 0;
        foreach ($interactions as $interaction) {
            if ($interaction->isVote() === false) {
                $downVotes++;
            }
        }

        return $downVotes;
    }
}
