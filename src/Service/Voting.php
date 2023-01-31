<?php

namespace App\Service;

use App\Entity\Decision;
use App\Entity\Interaction;
use App\Repository\InteractionRepository;
use Symfony\Component\HttpFoundation\Request;

class Voting
{
    private const UP_VOTE = "upVote";
    private const DOWN_VOTE = "downVote";

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

    public function voteRegister(Request $request, Interaction $interaction): Interaction
    {
        if (
            $request->get(self::DOWN_VOTE) === '' && $interaction->isVote() === false
            || $request->get(self::UP_VOTE) === '' && $interaction->isVote() === true
        ) {
            $interaction->setVote(null);
        } elseif ($request->get(self::DOWN_VOTE) === '') {
            $interaction->setVote(false);
        } elseif ($request->get(self::UP_VOTE) === '') {
            $interaction->setVote(true);
        }

        return $interaction;
    }
}
