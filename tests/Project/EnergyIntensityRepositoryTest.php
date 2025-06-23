<?php

namespace App\Tests\Project;

use App\Repository\EnergyIntensityRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EnergyIntensityRepositoryTest extends KernelTestCase
{
    public function testFindAllResults(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        /** @var \App\Repository\EnergyIntensityRepository $repo */
        $repo = $container->get(EnergyIntensityRepository::class);

        $result = $repo->findAll();

        $this->assertNotEmpty($result);
    }
}
