<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{

    public const SEASONS = [

        1 => [

            'year' => '2001',
            'description' => "Yuccie skateboard mumblecore, mlkshk plaid keytar flannel taiyaki pug raclette vaporware. Literally salvia organic meditation trust fund twee hoodie narwhal. Jianbing 8-bit crucifix, freegan marfa banjo meh narwhal pour-over ugh. Letterpress plaid DIY venmo 90's literally seitan readymade cronut tofu distillery pork belly lumbersexual succulents.",
        ],

        2 => [

            'year' => '2002',
            'description' => "Yuccie skateboard mumblecore, mlkshk plaid keytar flannel taiyaki pug raclette vaporware. Literally salvia organic meditation trust fund twee hoodie narwhal. Jianbing 8-bit crucifix, freegan marfa banjo meh narwhal pour-over ugh. Letterpress plaid DIY venmo 90's literally seitan readymade cronut tofu distillery pork belly lumbersexual succulents.",
        ],

        3 => [

            'year' => '2003',
            'description' => "Yuccie skateboard mumblecore, mlkshk plaid keytar flannel taiyaki pug raclette vaporware. Literally salvia organic meditation trust fund twee hoodie narwhal. Jianbing 8-bit crucifix, freegan marfa banjo meh narwhal pour-over ugh. Letterpress plaid DIY venmo 90's literally seitan readymade cronut tofu distillery pork belly lumbersexual succulents.",
        ],

        4 => [

            'year' => '2004',
            'description' => "Yuccie skateboard mumblecore, mlkshk plaid keytar flannel taiyaki pug raclette vaporware. Literally salvia organic meditation trust fund twee hoodie narwhal. Jianbing 8-bit crucifix, freegan marfa banjo meh narwhal pour-over ugh. Letterpress plaid DIY venmo 90's literally seitan readymade cronut tofu distillery pork belly lumbersexual succulents.",
        ],

        5 => [

            'year' => '2005',
            'description' => "Yuccie skateboard mumblecore, mlkshk plaid keytar flannel taiyaki pug raclette vaporware. Literally salvia organic meditation trust fund twee hoodie narwhal. Jianbing 8-bit crucifix, freegan marfa banjo meh narwhal pour-over ugh. Letterpress plaid DIY venmo 90's literally seitan readymade cronut tofu distillery pork belly lumbersexual succulents.",
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (ProgramFixtures::PROGRAMS as $title => $programDetails) {

            foreach (self::SEASONS as $seasonNumber => $seasonDetails) {
                $season = new Season();
                $season->setNumber($seasonNumber);
                $season->setYear($seasonDetails['year']);
                $season->setDescription($seasonDetails['description']);
                $season->setProgram($this->getReference('program_' . $title));
                $this->addReference('season_' . $title . '_' . $seasonNumber, $season);
                $manager->persist($season);
            };
                
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont SeasonFixtures dépend
        return [
            ProgramFixtures::class,
        ];
    }
}
