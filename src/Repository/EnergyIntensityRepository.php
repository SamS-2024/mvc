<?php

namespace App\Repository;

use App\Entity\EnergyIntensityPerGDP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EnergyIntensityPerGDP>
 */
class EnergyIntensityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnergyIntensityPerGDP::class);
    }
}