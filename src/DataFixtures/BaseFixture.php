<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;

abstract class BaseFixture extends Fixture
{
    /** @var @var Generator */
    protected $faker;

    public function load(ObjectManager $manager) {
        $this->manager = $manager;
        $this->faker = Factory::create();
    }
}
