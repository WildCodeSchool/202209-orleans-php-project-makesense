<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Status;
use App\Entity\Decision;
use App\Service\AutomatedDates;
use App\Service\TimelineManager;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/** @SuppressWarnings(PHPMD.ExcessiveMethodLength) */
class DecisionFixtures extends Fixture implements DependentFixtureInterface
{
    public const DECISION_NUMBER = 100;


    public function __construct(private AutomatedDates $automatedDates, private TimelineManager $timelineManager)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i <= self::DECISION_NUMBER; $i++) {
            $decision = new Decision();
            // The Decision with index 0 is in vote period TedyDoe is impacted therefore can vote
            // The Decision with index 1 is in first decision phase with TedyDoe as the creator
            // The Decision with index 2 is in final decision phase with TedyDoe as the creator
            // The Decision with index 3 is in conclict period and TedyDoe is impacted
            if ($i === 0) {
                $decision->setTitle('It is voting time !');
                $decision->setDecisionStartTime($faker->dateTimeBetween('-5 week', '-5 week'));
                $decision->setCreator($this->getReference('user_' . rand(0, (UserFixtures::GENERIC_USER_ACCOUNT))));
                $decision->setDetails($faker->paragraph(rand(2, 10)));
                $decision->setImpact($faker->paragraph(rand(2, 10)));
                $decision->setGain($faker->paragraph(rand(2, 10)));
                $decision->setRisk($faker->paragraph(rand(2, 10)));
            } elseif ($i === 1) {
                $decision->setTitle('Make your fist decision !');
                $decision->setDecisionStartTime($faker->dateTimeBetween('-1 week', '-1 week'));
                $decision->setCreator($this->getReference('user_' . (UserFixtures::GENERIC_USER_ACCOUNT + 1)));
                $decision->setDetails($faker->paragraph(rand(2, 10)));
                $decision->setImpact($faker->paragraph(rand(2, 10)));
                $decision->setGain($faker->paragraph(rand(2, 10)));
                $decision->setRisk($faker->paragraph(rand(2, 10)));
            } elseif ($i === 2) {
                $decision->setTitle('Make your final decision !');
                $decision->setDecisionStartTime($faker->dateTimeBetween('-5 week', '-5 week'));
                $decision->setCreator($this->getReference('user_' . (UserFixtures::GENERIC_USER_ACCOUNT + 1)));
                $decision->setDetails($faker->paragraph(rand(2, 10)));
                $decision->setImpact($faker->paragraph(rand(2, 10)));
                $decision->setGain($faker->paragraph(rand(2, 10)));
                $decision->setRisk($faker->paragraph(rand(2, 10)));
            } elseif ($i === 3) {
                $decision->setTitle('Acheter une nouvelle machine à càfé à grain');
                $decision->setDecisionStartTime($faker->dateTimeBetween('-3 week', '-3 week'));
                $decision->setCreator($this->getReference('user_' . rand(0, (UserFixtures::GENERIC_USER_ACCOUNT))));
                $decision->setDetails(
                    "<h3 style='color:#0d3944;font-family:'Raleway',sans-serif;font-size:1.60rem;font-weight:550;'>
                    Introduction</h3>
                     <h4 style='color:#0d3944;font-family:'Raleway',sans-serif;font-size:1.45rem;font-weight:475;'>
                     1. Localisation</h4>
                      <p style='color:#000000;font-family:'Raleway',sans-serif;font-size:1.2rem;font-weight:400;'>
                      Le bureau d'Orléans,
                       1 Av. du Champ de Mars, 45100 Orléans.</p> <h4 style='color:#0d3944;font-family:'Raleway',
                       sans-serif;font-size:
                        1.45rem;font-weight:475;'>2. Contexte</h4> <p style='color:#000000;font-family:'Raleway',
                        sans-serif;font-size:
                            1.2rem;font-weight:400;'>Actuellement nous utilisons du café en dosette en grande
                            quantité...</p> 
                            <p style='color:#000000;font-family:'Raleway',sans-serif;font-size:1.2rem;
                            font-weight:400;'> </p>"
                );
                $decision->setImpact(
                    "<h4 style='color:#0d3944;font-family:'Raleway',sans-serif;font-size:1.45rem;
                    font-weight:475;'>1. Moral</h4> 
                    <p style='color:#000000;font-family:'Raleway',sans-serif;font-size:1.2rem;
                    font-weight:400;'>Comme tout le monde 
                    le sait, le café peut jouer sur le moral.</p> <h4 style='color:#0d3944;font-family:
                    'Raleway',sans-serif;font-size
                    :1.45rem;font-weight:475;'>2. Economique</h4> <p style='color:#000000;font-family:
                    'Raleway',sans-serif;font-size:
                        1.2rem;font-weight:400;'>Le budget café de l'entreprise est assez élevé.</p>
                        <h4 style='color:#0d3944;font-family
                        :'Raleway',sans-serif;font-size:1.45rem;font-weight:475;'>3. Ecologique</h4>
                         <p style='color:#000000;font-family:
                            'Raleway',sans-serif;font-size:1.2rem;font-weight:400;'>Les dosettes non 
                            réutilisables ne sont pas bonnes pour
                             l'environnement.</p>"
                );
                $decision->setGain(
                    "<h3 style='color:#0d3944;font-family:'Raleway',sans-serif;font-size:1.60rem;
                    font-weight:550;'>Voici une liste
                     des bénéfices potentiels de cette décision :</h3> <h4 style='color:#0d3944;
                     font-family:'Raleway',sans-serif;
                     font-size:1.45rem;font-weight:475;'>1. Moral</h4> <p style='color:#000000;
                     font-family:'Raleway',sans-serif;
                     font-size:1.2rem;font-weight:400;'>Un boost de moral certain lié à la 
                     qualité du café grain acheté</p> 
                     <h4 style='color:#0d3944;font-family:'Raleway',sans-serif;font-size:
                        1.45rem;font-weight:475;'>2. Economique</h4> 
                     <p style='color:#000000;font-family:'Raleway',sans-serif;font-size:
                        1.2rem;font-weight:400;'>Le café en grain ou 
                     moulu est plus économique et se conserve sur un durée plus longue. 
                     Permettant de le stocker plus facilement.</p> 
                     <h4 style='color:#0d3944;font-family:'Raleway',sans-serif;font-size:
                        1.45rem;font-weight:475;'>3. Ecologique</h4>
                      <p style='color:#000000;font-family:'Raleway',sans-serif;font-size:
                        1.2rem;font-weight:400;'>Plus de dosettes,
                       possibilité d'acheter du café plus équitable.</p>"
                );
                $decision->setRisk(
                    "<h4 style='color:#0d3944;font-family:'Raleway',sans-serif;font-size:
                        1.45rem;font-weight:475;'>1. Economique</h4>
                     <p style='color:#000000;font-family:'Raleway',sans-serif;font-size:
                        1.2rem;font-weight:400;'>L'achat de bonnes
                      cafetières à grain est un investissement de départ assez elevé 
                      mais qui sera compensé sur la durée.</p>
                       <p style='color:#000000;font-family:'Raleway',sans-serif;
                       font-size:1.2rem;font-weight:400;'>De plus,
                        un coût de maintenance peut-être nécessaire.</p>"
                );
                $decision->setFirstDecision(
                    "<h4 style='color:#0d3944;font-family:'Raleway',sans-serif;
                    font-size:1.45rem;font-weight:475;'>Décision :</h4>
                     <p style='color:#000000;font-family:'Raleway',sans-serif;
                     font-size:1.2rem;font-weight:400;'>Remplacer 10 
                     des 15 anciennes machines pour le mois prochain.</p>"
                );
            } else {
                $decision->setTitle($faker->sentence(rand(15, 30)));
                $decision->setDecisionStartTime($faker->dateTimeBetween('-20 week', '+10 week'));
                $decision->setCreator($this->getReference('user_' . rand(0, (UserFixtures::GENERIC_USER_ACCOUNT))));
                $decision->setDetails($faker->paragraph(rand(2, 10)));
                $decision->setImpact($faker->paragraph(rand(2, 10)));
                $decision->setGain($faker->paragraph(rand(2, 10)));
                $decision->setRisk($faker->paragraph(rand(2, 10)));
            }
            $decision->setFirstDecisionEndDate($this->automatedDates->firstDecisionEndDateCalculation($decision));
            $decision->setConflictEndDate($this->automatedDates->conflictEndDateCalculation($decision));
            $decision->setFinalDecisionEndDate($this->automatedDates->finalDecisionEndDateCalculation($decision));
            $decision->setCategory($this->getReference('category_' . rand(0, 5)));
            // If the decision is in final state then it already have a first decision
            if ($this->timelineManager->checkDecisionStatus($decision) === Status::FINAL_DECISION) {
                $decision->setFirstDecision($faker->paragraph(rand(2, 10)));
            }
            $this->addReference('decision_' . $i, $decision);

            $manager->persist($decision);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [

            UserFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
