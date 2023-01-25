<?php

namespace App\Security;

use App\Entity\Decision;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class DecisionVoter extends Voter
{
    private const EDIT = 'edit';

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::EDIT])) {
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
            default => throw new \LogicException('Vous n\'avez pas accès à cette page.')
        };
    }

    private function canEdit(Decision $decision, User $user): bool
    {
        return $user === $decision->getCreator();
    }
}
