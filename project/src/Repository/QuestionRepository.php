<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    public function getAll()
    {
        $qb = $this->createQueryBuilder('q')
            ->orderBy('q.idquestion', 'ASC');

        return $qb->getQuery()->getResult();
    }
}