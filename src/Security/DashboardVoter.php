<?php

namespace App\Security;

use App\Entity\Decision;
use App\Entity\User;
use App\Repository\InteractionRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class DashboardVoter extends Voter
{
    private const VIEW = 'view';

    public function __construct(private InteractionRepository $interactionRepo)
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::VIEW])) {
            return false;
        }

        if (!$subject instanceof User) {
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

        $dashboardOwner = $subject;

        return match ($attribute) {
            self::VIEW => $this->canView($dashboardOwner, $user),
            default => throw new \LogicException('Vous n\'avez pas accès à cette page.')
        };
    }

    private function canView(User $dashboardOwner, User $user): bool
    {
        return $user === $dashboardOwner;
    }
}
