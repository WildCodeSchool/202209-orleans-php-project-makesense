<?php

namespace App\Security;

use App\Entity\Decision;
use App\Entity\Interaction;
use App\Entity\User;
use App\Repository\InteractionRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class DecisionVoter extends Voter
{
    private const EDIT = 'edit';
    private const VOTE = 'vote';

    public function __construct(private InteractionRepository $interactionRepo)
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::EDIT, self::VOTE])) {
            return false;
        }

        if (!$subject instanceof Decision) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Decision $decision */
        $decision = $subject;

        return match ($attribute) {
            self::EDIT => $this->canEdit($decision, $user),
            self::VOTE => $this->canVote($decision, $user),
            default => throw new \LogicException('Vous n\'avez pas accès à cette page.')
        };
    }

    private function canEdit(Decision $decision, User $user): bool
    {
        return $user === $decision->getCreator();
    }

    public function canVote(Decision $decision, User $user): bool
    {
        $authorizedUsers = [];
        foreach ($decision->getInteractions() as $interaction) {
            $authorizedUsers[] = $interaction->getUser();
        }

        return in_array($user, $authorizedUsers);
    }
}
