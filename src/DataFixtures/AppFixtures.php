<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Ticket;
use App\Entity\Departement;
use Doctrine\Persistence\ObjectManager;
use App\Faker\Provider\ImmutableDateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    protected UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {


        $faker = Factory::create('fr_FR');


        /**
         * création de 5 utilisateurs
         */
        for ($u = 0; $u < 5; $u++) {
            $user = new User;

            $hash = $this->hasher->hashPassword($user, "afpa");

            if ($u === 0) {
                $user->setRoles(["ROLE_ADMIN"])
                    ->setEmail("admin@test.bzh");
            } else {
                $user->setEmail("user{$u}@test.bzh");
            }



            $user->setName($faker->name())
                ->setPassword($hash);

            /**
             * persistence des données
             */
            $manager->persist($user);
        }

        /**
         * création de département *10
         */
        for ($d = 0; $d < 10; $d++) {
            $departement = new Departement;

            $departement->setName($faker->company());


            $manager->persist($departement);
        }

        /**
         * On push les de)p en bdd
         */
        $manager->flush();

        $allDpartements = $manager->getRepository(Departement::class)
            ->findAll();




        // création entre 30 et 50 ticket aléatoire
        for ($t = 0; $t < mt_rand(30, 50); $t++) {

            $ticket = new Ticket;

            $ticket->setMessage($faker->paragraph(3))
                ->setComment($faker->paragraph(3))
                ->setTicketStatut($faker->randomElement(['initial']))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setFinishedAt($ticket->getTicketStatut() != "finished" ? ImmutableDateTime::immutableDateTimeBetween('now', '6 months') : null)
                ->setObject($faker->sentence(6))
                ->setDepartement($faker->randomElement($allDpartements));

            $manager->persist($ticket);
        }

        $manager->flush();
    }
}
