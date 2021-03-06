<?php
/**
 * Advertisement fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Advertisement;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class AdvertisementFixtures.
 */
class AdvertisementFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(50, 'Advertisements', function ($i) {
            $Advertisement = new Advertisement();
            $Advertisement->setTitle($this->faker->sentence);
            $Advertisement->setContent($this->faker->sentence);
            $Advertisement->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $Advertisement->setUpdatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $Advertisement->setCategory($this->getRandomReference('categories'));

            return $Advertisement;
        });

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array Array of dependencies
     */
    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }
}