<?php

namespace App\Tests\Project;

use App\Entity\EnergyIntensityPerGDP;
use PHPUnit\Framework\TestCase;

class EnergyIntensityPerGDPTest extends TestCase
{
    public function testGetId(): void
    {
        $entity = new EnergyIntensityPerGDP();
        $this->assertNull($entity->getId());
    }

    public function testSetAndGetYear(): void
    {
        $entity = new EnergyIntensityPerGDP();
        $entity->setYear(2015);
        $this->assertEquals(2015, $entity->getYear());
    }

    public function testSetAndGetIntensityChange(): void
    {
        $entity = new EnergyIntensityPerGDP();
        $entity->setIntensityChangePercent(-1.4);
        $this->assertEquals(-1.4, $entity->getIntensityChangePercent());
    }
}
