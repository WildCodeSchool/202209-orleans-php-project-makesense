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
    private const VOTE_RATIO_ROUND_PRECISION = 4;

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

    public function getVoteRatio(Decision $decision): ?float
    {
        if ($this->countUpVotes($decision) > $this->countDownVotes($decision)) {
            return round(
                $this->countUpVotes($decision) /
                    ($this->countDownVotes($decision) + $this->countUpVotes($decision)),
                self::VOTE_RATIO_ROUND_PRECISION
            ) * 100;
        } elseif ($this->countDownVotes($decision) > $this->countUpVotes($decision)) {
            return round(
                $this->countDownVotes($decision) /
                    ($this->countDownVotes($decision) + $this->countUpVotes($decision)),
                self::VOTE_RATIO_ROUND_PRECISION
            ) * 100;
        } else {
            return null;
        }
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
