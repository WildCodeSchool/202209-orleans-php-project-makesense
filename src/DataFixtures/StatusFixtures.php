<?php

namespace App\DataFixtures;

use App\Entity\Status;
use App\Service\TimelineManager;
use App\DataFixtures\DecisionFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class StatusFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private TimelineManager $timelineManager)
    {
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i <= DecisionFixtures::DECISION_NUMBER; $i++) {
            $status = new Status();
            $status->setDecisionStatus(
                $this->timelineManager->checkDecisionStatus(
                    $this->getReference('decision_' . $i)
                )
            );
            $status->setStatusColor(
                Status::STATUS_COLORS[$status->getDecisionStatus()]
            );
            $status->setStatusDaysLeft(
                $this->timelineManager->getStatusDaysLeft(
                    $this->getReference('decision_' . $i)
                )
            );
            $status->setDecision($this->getReference('decision_' . $i));

            $manager->persist($status);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            DecisionFixtures::class
        ];
    }
}
