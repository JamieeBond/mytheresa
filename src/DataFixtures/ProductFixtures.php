<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Fixture to populate product base data
 */
class ProductFixtures extends Fixture
{
    /**
     * Product population
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $manager->persist(new Product(
            '000001',
            'BV Lean leather ankle boots',
            'boots',
            89000
        ));

        $manager->persist(new Product(
            '000002',
            'BV Lean leather ankle boots',
            'boots',
            99000
        ));

        $manager->persist(new Product(
            '000003',
            'Ashlington leather ankle boots',
            'boots',
            71000
        ));

        $manager->persist(new Product(
            '000004',
            'Naima embellished suede sandals',
            'sandals',
            79500
        ));

        $manager->flush();
    }
}
