<?php

namespace App\DataFixtures;

use App\Entity\Program;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{

    public const PROGRAMS = [

        'Ratched' => [
            'summary' => 'Ratched is a suspenseful drama series that tells the origin story of asylum nurse Mildred Ratched. In 1947, Mildred arrives in Northern California to seek employment at a leading psychiatric hospital where new and unsettling experiments have begun on the human mind.',
            'poster' => 'https://fr.web.img6.acsta.net/pictures/20/09/09/10/38/4773967.jpg',
            'category' => '6',
        ],

        'Breaking bad' => [
            'summary' => "A high school chemistry teacher diagnosed with inoperable lung cancer turns to manufacturing and selling methamphetamine in order to secure his familys future.",
            'poster' => 'https://m.media-amazon.com/images/M/MV5BMjhiMzgxZTctNDc1Ni00OTIxLTlhMTYtZTA3ZWFkODRkNmE2XkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_UY268_CR5,0,182,268_AL_.jpg',
            'category' => '0',
        ],

        'Game of thrones' => [
            'summary' => 'Nine noble families fight for control over the lands of Westeros, while an ancient enemy returns after being dormant for millennia.',
            'poster' => 'https://m.media-amazon.com/images/M/MV5BYTRiNDQwYzAtMzVlZS00NTI5LWJjYjUtMzkwNTUzMWMxZTllXkEyXkFqcGdeQXVyNDIzMzcwNjc@._V1_UY268_CR7,0,182,268_AL_.jpg',
            'category' => '5',
        ],

        'This is us' => [
            'summary' => 'A heartwarming and emotional story about a unique set of triplets, their struggles and their wonderful parents.',
            'poster' => 'https://m.media-amazon.com/images/M/MV5BYjNlOWY2OWEtMGQyOC00YWQ4LWJkMjUtYzU4NGEzNjM2MWY0XkEyXkFqcGdeQXVyODUxOTU0OTg@._V1_UX182_CR0,0,182,268_AL_.jpg',
            'category' => '6',
        ],

        'Stranger things' => [
            'summary' => 'When a young boy disappears, his mother, a police chief and his friends must confront terrifying supernatural forces in order to get him back.',
            'poster' => 'https://m.media-amazon.com/images/M/MV5BN2ZmYjg1YmItNWQ4OC00YWM0LWE0ZDktYThjOTZiZjhhN2Q2XkEyXkFqcGdeQXVyNjgxNTQ3Mjk@._V1_UX182_CR0,0,182,268_AL_.jpg',
            'category' => '5',
        ]
    ];

    private Slugify $slugify;

     public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager)
    {

        foreach (self::PROGRAMS as $title => $qualification) {
            $program = new Program;
            $program->setTitle($title);
            $program->setSummary($qualification['summary']);
            $program->setPoster($qualification['poster']);
            $program->setCategory($this->getReference('category_' . $qualification['category']));
            
            for ($i = 0; $i < count(ActorFixtures::ACTORS); $i++) {
                $program->addActor($this->getReference('actor_' . $i));
            }
            $this->addReference('program_' . $title, $program);
             $program->setSlug($this->slugify->generateSlug($program->getTitle()));
            $manager->persist($program);
           
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            ActorFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
