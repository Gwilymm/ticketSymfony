<?php

namespace App\DataFixtures;

use App\Entity\Ticket;
use App\Faker\Provider\ImmutableDateTime;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR');

        // création entre 30 et 50 ticket aléatoire
        for ($t = 0; $t < mt_rand(30, 50); $t++) {

            $ticket = new Ticket;

            $ticket->setMessage($faker->paragraph(3))
                ->setComment($faker->paragraph(3))
                ->setIsActive($faker->boolean(75))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setFinishedAt(!$ticket->getIsActive() ? ImmutableDateTime::immutableDateTimeBetween('now', '6 months') : null)
                ->setObject($faker->sentence(6));

            $manager->persist($ticket);
        }

        $manager->flush();
    }
}
