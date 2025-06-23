<?php

namespace App\Tests\Project;

// Repository-klassen som ska testas.
use App\Repository\RenewableEnergyTWhRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RenewableEnergyTWhRepositoryTest extends KernelTestCase
{
    public function testFindAllResults(): void
    {
        // Startar symfony applikations kärna
        self::bootKernel();

        // Hämtar service-containern från Symfony. Används för att få ut tjänster som repositories.
        $container = self::getContainer();

        // Hämtar repository
        /** @var \App\Repository\RenewableEnergyTWhRepository $repo */
        $repo = $container->get(RenewableEnergyTWhRepository::class);

        // Kör Doctrine-metoden som returnerar alla entiteter i tabellen.
        $result = $repo->findAll();

        $this->assertNotEmpty($result);
    }
}
