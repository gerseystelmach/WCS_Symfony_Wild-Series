<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\DataFixtures\SeasonFixtures;
use App\DataFixtures\ProgramFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface

{

    public const EPISODES =
    [
        1 => [

            'title' => 'Pilot',
            'synopsis' => "Yuccie skateboard mumblecore, mlkshk plaid keytar flannel taiyaki pug raclette vaporware. Literally salvia organic meditation trust fund twee hoodie narwhal. Jianbing 8-bit crucifix, freegan marfa banjo meh narwhal pour-over ugh. Letterpress plaid DIY venmo 90's literally seitan readymade cronut tofu distillery pork belly lumbersexual succulents.",
        ],

        2 => [

            'title' => 'Yuccie',
            'synopsis' => "Yuccie skateboard mumblecore, mlkshk plaid keytar flannel taiyaki pug raclette vaporware. Literally salvia organic meditation trust fund twee hoodie narwhal. Jianbing 8-bit crucifix, freegan marfa banjo meh narwhal pour-over ugh. Letterpress plaid DIY venmo 90's literally seitan readymade cronut tofu distillery pork belly lumbersexual succulents.",
        ],

        3 => [

            'title' => 'Skateboard',
            'synopsis' => "Yuccie skateboard mumblecore, mlkshk plaid keytar flannel taiyaki pug raclette vaporware. Literally salvia organic meditation trust fund twee hoodie narwhal. Jianbing 8-bit crucifix, freegan marfa banjo meh narwhal pour-over ugh. Letterpress plaid DIY venmo 90's literally seitan readymade cronut tofu distillery pork belly lumbersexual succulents.",
        ],

        4 => [

            'title' => 'Mumblecore',
            'synopsis' => "Yuccie skateboard mumblecore, mlkshk plaid keytar flannel taiyaki pug raclette vaporware. Literally salvia organic meditation trust fund twee hoodie narwhal. Jianbing 8-bit crucifix, freegan marfa banjo meh narwhal pour-over ugh. Letterpress plaid DIY venmo 90's literally seitan readymade cronut tofu distillery pork belly lumbersexual succulents.",
        ],

        5 => [

            'title' => 'Flannel taiyak',
            'synopsis' => "Yuccie skateboard mumblecore, mlkshk plaid keytar flannel taiyaki pug raclette vaporware. Literally salvia organic meditation trust fund twee hoodie narwhal. Jianbing 8-bit crucifix, freegan marfa banjo meh narwhal pour-over ugh. Letterpress plaid DIY venmo 90's literally seitan readymade cronut tofu distillery pork belly lumbersexual succulents.",
        ],

    ];


    public function load(ObjectManager $manager)
    {

        foreach (ProgramFixtures::PROGRAMS as $programTitle => $programdetails) {
            foreach (SeasonFixtures::SEASONS as $seasonNumber => $seasonDetails) {
                foreach (self::EPISODES as $episodeNumber => $qualification) {
                    $episode = new Episode;
                    $episode->setNumber($episodeNumber);
                    $episode->setTitle($qualification['title']);
                    $episode->setSynopsis($qualification['synopsis']);
                    $episode->setSeason($this->getReference('season_' . $programTitle . '_' . $seasonNumber));
                    $this->setReference('episode_season' . $seasonNumber . '_' . $programTitle, $episode);
                    $manager->persist($episode);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont EpisodeFixtures dépend
        return [
            SeasonFixtures::class,    
        ];
    }
}
