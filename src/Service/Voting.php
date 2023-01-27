<?php

namespace App\Service;

use App\Entity\Decision;
use App\Repository\InteractionRepository;

class Voting
{
    public function __construct(private InteractionRepository $interactionRepo)
    {
    }

    public function countUpVotes(Decision $decision): int
    {
        return count($this->interactionRepo->findBy(['decision' => $decision, 'vote' => true]));
    }

    public function countDownVotes(Decision $decision): int
    {

        return count($this->interactionRepo->findBy(['decision' => $decision, 'vote' => false]));
    }
}
