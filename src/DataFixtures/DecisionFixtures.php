<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Status;
use App\Entity\Decision;
use App\Entity\Interaction;
use App\Service\AutomatedDates;
use App\Service\TimelineManager;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/** @SuppressWarnings(PHPMD.ExcessiveMethodLength) */
class DecisionFixtures extends Fixture implements DependentFixtureInterface
{
    public const DECISION_NUMBER = 100;
    public const DECISION_FINISHED_IMPACTED_USERS_VOTES = 10;


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
                $decision->setTitle('Création d\'un poste de développeur PHP/Symfony');
                $decision->setDecisionStartTime($faker->dateTimeBetween('-5 week', '-5 week'));
                $decision->setCreator($this->getReference('user_' . rand(0, (UserFixtures::GENERIC_USER_ACCOUNT))));
                $decision->setDetails("<h3 style='color:#0d3944;font-family:'Raleway',sans-serif;font-size:1.60rem;
                font-weight:550;'>Définition du besoin</h3> <h4 style='color:#0d3944;font-family:'Raleway',sans-serif
                ;font-size:1.45rem;font-weight:475;'>1. Maintenance de la plateforme de prise de décision</h4>
                 <p style='color:#000000;font-family:'Raleway',sans-serif;font-size:1.2rem;font-weight:400;'>
                 Suite au déploiement de notre nouvelle super-plateforme de prise de décision.</p> 
                 <h4 style='color:#0d3944;font-family:'Raleway',sans-serif;font-size:1.45rem;font-weight:475;'>
                 2. Création de job board</h4> <p style='color:#000000;font-family:'Raleway',sans-serif;
                 font-size:1.2rem;font-weight:400;'>Au vu de tous les jobs à pourvoir au sein de nos nombreuses 
                 filiales. Un projet de job board est en cours de définition.</p>");
                $decision->setImpact("<h4 style='color:#0d3944; font-family:'Raleway',
                sans-serif; font-size:1.45rem; font-weight:475'>1. Formation du nouveau poste</h4> 
                <p style='color:#000000; font-family:'Raleway',sans-serif; font-size:1.2rem; 
                font-weight:400'>Gérer l'intégration et la sensibilisation à notre environnement
                 logiciel.</p>");
                $decision->setGain("<h4 style='color:#0d3944; font-family:'Raleway',sans-serif;
                 font-size:1.45rem; font-weight:475'>1. Possibilité de mettre en place plus facilement 
                 de nouveaux outils webs</h4> <p style='color:#000000; font-family:'Raleway',sans-serif; 
                 font-size:1.2rem; font-weight:400'>Avoir un développeur est toujours utile dans une entreprise.</p> 
                 <h4 style='color:#0d3944; font-family:'Raleway',sans-serif; font-size:1.45rem; font-weight:475'>2.
                  Développer notre chiffre d'affaire</h4> <p style='color:#000000; font-family:'Raleway',sans-serif;
                   font-size:1.2rem; font-weight:400'>Pouvoir plus facilement élargir notre offre de service en 
                   proposant 
                   de nouvelles zones de chalandise digitale.</p>");
                $decision->setRisk("<h4 style='color:#0d3944; font-family:'Raleway',sans-serif;
                 font-size:1.45rem; font-weight:475'>1. Bureaux et open-space surpeuplé</h4>
                  <p style='color:#000000;font-family:'Raleway',sans-serif;font-size:1.2rem;font-weight:400;'> </p> 
                  <p style='color:#000000; font-family:'Raleway',sans-serif; font-size:1.2rem; font-weight:400'> </p>");
                $decision->setFirstDecision(
                    "<h4 style='color:#0d3944;font-family:'Raleway',sans-serif;
                    font-size:1.45rem;font-weight:475;'>Décision :</h4>
                     <p style='color:#000000;font-family:'Raleway',sans-serif;
                     font-size:1.2rem;font-weight:400;'>Prendre plutôt un poste en alternance pour commencer.
                     Si le besoin devient permanent alors prendre un CDI sera envisageable.</p>"
                );
                $decision->setCategory($this->getReference('category_0'));
                $decision->setFinalDecision("<h4 style='color:#0d3944;font-family:'Raleway',sans-serif;
                font-size:1.45rem;font-weight:475;'>Décision :</h4>
                 <p style='color:#000000;font-family:'Raleway',sans-serif;
                 font-size:1.2rem;font-weight:400;'>Je confirme la 1ère décision qui est de prendre plutôt un poste en
                  alternance plutôt qu'un CDI suite au manque de conflit sur cette décisions.</p>");
            } elseif ($i === 1) {
                $decision->setTitle('Changement des photocopieuses du département comptabilité - 4 semaines plus tard');
                $decision->setDecisionStartTime($faker->dateTimeBetween('-5 week', '-5 week'));
                $decision->setCreator($this->getReference('user_' . (UserFixtures::GENERIC_USER_ACCOUNT + 1)));
                $decision->setDetails("<h3 style='color:#0d3944; font-family:'Raleway',sans-serif; 
                font-size:1.60rem;
                 font-weight:550'><strong>Détails </strong></h3> <h4 style='color:#0d3944;
                  font-family:'Raleway',sans-serif;
                  font-size:1.45rem; font-weight:475'><strong>Les photocopieuses vieillissantes
                   sont malheureusement souvent
                   en panne.</strong></h4> <p style='color:#000000; font-family:'Raleway'
                   ,sans-serif; font-size:1.2rem; 
                   font-weight:400'>J’aimerais soumettre l’idée d’un éventuel plan financier 
                   pour changer les photocopieuses
                    de tout le service comptabilité, elles ont maintenant un certain age et 
                    ont un manque de fonctionnalité 
                    non négligeable pour le fonctionnement d’un service au jour d’aujourd’hui. 
                    J’aimerais aussi mentionner le 
                    nombre d’interventions de réparation en 2022 qui n’est pas négligeable, 
                    sans parler du fait qu’à chaque
                     photocopieuse en panne les redirections d’imprimeries sur les imprimantes 
                     restantes créer certains soucis
                      de confidentialité et de logistiques.<br /> Je me permets de soumettre 
                      une approche du côté de la marque
                       Canon et plus particulièrement de la Série image RUNNER ADVANCE C5500
                        ES qui équipait mon ancienne
                        entreprise
                        et dont je peux attester de sa fiabilité.</p>");
                $decision->setImpact("<h3 style='color:#0d3944; font-family:'Raleway',sans-serif; font-size:1.60rem;
                 font-weight:550'>
                Impact</h3> <p style='color:#000000; font-family:'Raleway',
                sans-serif; font-size:1.2rem; font-weight:400'>
                L’impact de
                 ce changement se fera principalement lors de la transition et 
                 plus particulièrement lors de l’installation 
                 des nouvelles
                  machines ainsi que le temps que l’ensemble des employés s’habituent à l’interface propre des machines.
                  On parle ici
                   vraiment de court terme, c’est un processus qui peut être un peu gênant, mais sans avoir d’impact
                    sur la productivité du service.</p>");
                $decision->setGain("<h3 style='color:#0d3944; font-family:'Raleway',sans-serif; font-size:1.60rem; 
                font-weight:550'>Bénéfices</h3> <p style='color:#000000; font-family:'Raleway',
                sans-serif; font-size:1.2rem; 
                font-weight:400'>Le bénéfice principal et une vitesse et une qualité d’impression/scan beaucoup plus
                 élevées que
                 nos machines actuelles. Avoir des imprimantes plus réactives permet un gain de temps total annuel
                  non négligeable
                  sur la productivité du service.Je tiens aussi à mettre le point sur le fait qu’elles permettent
                   de s’y connecter 
                  avec un mobile et/ou d’un cloud, ce qui permet d’imprimer directement depuis un mobile ou un 
                  ordinateur portable,
                   augmentant ainsi la productivité.</p>");
                $decision->setRisk("<h3 style='color:#0d3944; font-family:'Raleway',sans-serif; font-size:1.60rem; 
                font-weight:550'>
                Risques</h3> <p style='color:#000000; font-family:'Raleway',sans-serif; font-size:1.2rem;
                 font-weight:400'>Le risque 
                principal est le coût financier du changement des 4 imprimantes que compose notre service
                 comptabilité. Ce n’est pas
                 négligeable et j’imagine bien que le budget à de meilleures réponses à remplir.Maintenant 
                 le risque de ne pas les
                  imprimantes d’ici un futur proche est celui de pannes de plusieurs machines en même temps 
                  et un ralentissement de 
                  la productivité. Au vu du nombre d’impressions annuel de notre département, l’idée de 
                  perdre une à deux imprimantes
                   n’est vraiment pas négligeable.</p>");
                $decision->setFirstDecision(
                    "<h4 style='color:#0d3944;font-family:'Raleway',sans-serif;
                    font-size:1.45rem;font-weight:475;'>Décision :</h4>
                     <p style='color:#000000;font-family:'Raleway',sans-serif;
                     font-size:1.2rem;font-weight:400;'>Faire en sorte de remplacer une imprimante par trimestre,
                     ainsi toutes les imprimantes devraient être neuves d'ici l'hivers prochain. De plus, les salariés
                     pourront utiliser au moins une imprimante en cas de panne</p>"
                );
                $decision->setCategory($this->getReference('category_1'));
            } elseif ($i === 2) {
                $decision->setTitle('Changement des photocopieuses du département comptabilité.');
                $decision->setDecisionStartTime($faker->dateTimeBetween('-1 week', '-1 week'));
                $decision->setCreator($this->getReference(
                    'user_' . (UserFixtures::GENERIC_USER_ACCOUNT + 1)
                ));
                $decision->setDetails("<h3 style='color:#0d3944; font-family:'Raleway',sans-serif;
                 font-size:1.60rem;
                 font-weight:550'><strong>Détails </strong></h3> <h4 style='color:#0d3944;
                  font-family:'Raleway',sans-serif;
                  font-size:1.45rem; font-weight:475'><strong>Les photocopieuses vieillissantes
                   sont malheureusement souvent
                   en panne.</strong></h4> <p style='color:#000000; font-family:'Raleway',
                   sans-serif; font-size:1.2rem; 
                   font-weight:400'>J’aimerais soumettre l’idée d’un éventuel plan financier 
                   pour changer les photocopieuses
                    de tout le service comptabilité, elles ont maintenant un certain age et ont
                     un manque de fonctionnalité 
                    non négligeable pour le fonctionnement d’un service au jour d’aujourd’hui. 
                    J’aimerais aussi mentionner le 
                    nombre d’interventions de réparation en 2022 qui n’est pas négligeable, sans
                     parler du fait qu’à chaque
                     photocopieuse en panne les redirections d’imprimeries sur les imprimantes
                      restantes créer certains soucis
                      de confidentialité et de logistiques.<br /> Je me permets de soumettre une
                      approche du côté de la marque
                       Canon et plus particulièrement de la Série image RUNNER ADVANCE C5500 ES 
                       qui équipait mon ancienne entreprise
                        et dont je peux attester de sa fiabilité.</p>");
                $decision->setImpact("<h3 style='color:#0d3944; font-family:'Raleway',sans-serif; 
                font-size:1.60rem; font-weight:550'>
                Impact</h3> <p style='color:#000000; font-family:'Raleway',sans-serif; 
                font-size:1.2rem; font-weight:400'>L’impact de
                 ce changement se fera principalement lors de la transition et plus particulièrement 
                 lors de l’installation des nouvelles
                  machines ainsi que le temps que l’ensemble des employés s’habituent à l’interface
                   propre des machines.On parle ici
                   vraiment de court terme, c’est un processus qui peut être un peu gênant, 
                   mais sans avoir d’impact sur la productivité du service.</p>");
                $decision->setGain("<h3 style='color:#0d3944; font-family:'Raleway',sans-serif; 
                font-size:1.60rem; 
                font-weight:550'>Bénéfices</h3> <p style='color:#000000; font-family:'Raleway',
                sans-serif; font-size:1.2rem; 
                font-weight:400'>Le bénéfice principal et une vitesse et une qualité d’impression/scan
                 beaucoup plus élevées que
                 nos machines actuelles. Avoir des imprimantes plus réactives permet un gain de 
                 temps total annuel non négligeable
                  sur la productivité du service.Je tiens aussi à mettre le point sur le fait qu’elles
                   permettent de s’y connecter 
                  avec un mobile et/ou d’un cloud, ce qui permet d’imprimer directement depuis un
                   mobile ou un ordinateur portable,
                   augmentant ainsi la productivité.</p>");
                $decision->setRisk("<h3 style='color:#0d3944; font-family:'Raleway',sans-serif;
                 font-size:1.60rem; font-weight:550'>
                Risques</h3> <p style='color:#000000; font-family:'Raleway',sans-serif; font-size:1.2rem; 
                font-weight:400'>Le risque 
                principal est le coût financier du changement des 4 imprimantes que compose notre 
                service comptabilité. Ce n’est pas
                 négligeable et j’imagine bien que le budget à de meilleures réponses à remplir.
                 Maintenant le risque de ne pas les
                  imprimantes d’ici un futur proche est celui de pannes de plusieurs machines en 
                  même temps et un ralentissement de 
                  la productivité. Au vu du nombre d’impressions annuel de notre département, 
                  l’idée de perdre une à deux imprimantes
                   n’est vraiment pas négligeable.</p>");
                $decision->setCategory($this->getReference('category_1'));
            } elseif ($i === 3) {
                $decision->setTitle('Acheter une nouvelle machine à café à grain');
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
                $decision->setCategory($this->getReference('category_0'));
            } else {
                $decision->setTitle($faker->sentence(rand(15, 30)));
                $decision->setDecisionStartTime($faker->dateTimeBetween('-10 week', '+1 week'));
                $decision->setCreator($this->getReference('user_' . rand(0, (UserFixtures::GENERIC_USER_ACCOUNT))));
                $decision->setDetails($faker->paragraph(rand(2, 10)));
                $decision->setImpact($faker->paragraph(rand(2, 10)));
                $decision->setGain($faker->paragraph(rand(2, 10)));
                $decision->setRisk($faker->paragraph(rand(2, 10)));
                $decision->setCategory($this->getReference('category_' . rand(0, 5)));
                if ($this->timelineManager->checkDecisionStatus($decision) === Status::FINAL_DECISION) {
                    $decision->setFirstDecision($faker->paragraph(rand(2, 10)));
                }
                if ($this->timelineManager->checkDecisionStatus($decision) === Status::DECISION_FINISHED) {
                    for ($o = 0; $o < self::DECISION_FINISHED_IMPACTED_USERS_VOTES; $o++) {
                        $interaction = new Interaction();
                        $interaction->setUser(
                            $this->getReference('user_' . rand(0, (UserFixtures::GENERIC_USER_ACCOUNT)))
                        );
                        $interaction->setDecisionRole(Interaction::DECISION_IMPACTED);
                        $interaction->setVote($faker->boolean());
                        $decision->addInteraction($interaction);
                    }
                }
            }
            $decision->setFirstDecisionEndDate($this->automatedDates->firstDecisionEndDateCalculation($decision));
            $decision->setConflictEndDate($this->automatedDates->conflictEndDateCalculation($decision));
            $decision->setFinalDecisionEndDate($this->automatedDates->finalDecisionEndDateCalculation($decision));

            // If the decision is in final state then it already have a first decision

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
