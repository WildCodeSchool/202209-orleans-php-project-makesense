<?php

namespace App\Security;

use App\Entity\Decision;
use App\Entity\User;
use App\Repository\InteractionRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CommentVoter extends Voter
{
    private const COMMENT = 'comment';

    public function __construct(private InteractionRepository $interactionRepo)
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::COMMENT])) {
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
            self::COMMENT => $this->canComment($decision, $user),
            default => throw new \LogicException('Vous n\'avez pas accès à cette page.')
        };
    }

    public function canComment(Decision $decision, User $user): bool
    {
        $interactions = $this->interactionRepo->findBy(['decision' => $decision]);

        $allowedUsers[] = $decision->getCreator();
        foreach ($interactions as $interaction) {
            $allowedUsers[] = $interaction->getUser();
        }

        return in_array($user, $allowedUsers);
    }
}
