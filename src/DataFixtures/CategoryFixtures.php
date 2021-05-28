<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{

    const CATEGORIES = [
        'Action',
        'Adventure',
        'Animation',
        'Horror',
        'Comedy',
        'Scifi'
    ];
    
    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $key => $categoryName) {  
        $category = new Category();  
        $category->setName($categoryName);  

        $manager->persist($category);  
    }  
    $manager->flush();
    }
}