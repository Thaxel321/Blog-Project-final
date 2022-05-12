<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i<10; $i++){
            $article = new Article();
            $article->setTitle("Article n°$i");
            $article->setContent("Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati officiis porro totam autem minus itaque pariatur alias quam! Dignissimos et maiores repudiandae suscipit quam repellat architecto maxime voluptatem obcaecati ex.
        ");
            $article->setCreateAt(new \DateTime());
            $manager->persist($article);
    }
        $manager->flush();
    }
}
