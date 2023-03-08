<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Question;


class QuestionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++){
            $question = new Question();
            $question->setIdquestion($i);
            $question->setTextequestion("Texte de la question $i");
            $question->setPointsquestion(random_int(1, 5));
            $manager->persist($question);
        }

        $manager->flush();
    }
}
