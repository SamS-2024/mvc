<?php

namespace App\Tests\Project;

use App\Entity\RenewableEnergyTWh;
use PHPUnit\Framework\TestCase;

class RenewableEnergyTWhTest extends TestCase
{
    public function testSetAndGetYear(): void
    {
        $entity = new RenewableEnergyTWh();
        $this->assertNull($entity->getId());
        $entity->setYear(2021);
        $this->assertEquals(2021, $entity->getYear());
    }

    public function testSetAndGetBiofuels(): void
    {
        $entity = new RenewableEnergyTWh();
        $entity->setBiofuels(10);
        $this->assertEquals(10, $entity->getBiofuels());
    }

    public function testSetAndGetHydropower(): void
    {
        $entity = new RenewableEnergyTWh();
        $entity->setHydropower(20);
        $this->assertEquals(20, $entity->getHydropower());
    }

    public function testSetAndGetWindPower(): void
    {
        $entity = new RenewableEnergyTWh();
        $entity->setWindPower(30);
        $this->assertEquals(30, $entity->getWindPower());
    }

    public function testSetAndGetHeatPumps(): void
    {
        $entity = new RenewableEnergyTWh();
        $entity->setHeatPumps(40);
        $this->assertEquals(40, $entity->getHeatPumps());
    }

    public function testSetAndGetSolarEnergy(): void
    {
        $entity = new RenewableEnergyTWh();
        $entity->setSolarEnergy(50);
        $this->assertEquals(50, $entity->getSolarEnergy());
    }

    public function testSetAndGetTotal(): void
    {
        $entity = new RenewableEnergyTWh();
        $entity->setTotal(200);
        $this->assertEquals(200, $entity->getTotal());
    }

    public function testSetAndGetStatisticalTransfer(): void
    {
        $entity = new RenewableEnergyTWh();
        $entity->setStatisticalTransfer(5);
        $this->assertEquals(5, $entity->getStatisticalTransfer());
    }

    public function testSetAndGetTargetCalculation(): void
    {
        $entity = new RenewableEnergyTWh();
        $entity->setTargetCalculation(15);
        $this->assertEquals(15, $entity->getTargetCalculation());
    }

    public function testSetAndGetTotalEnergyUse(): void
    {
        $entity = new RenewableEnergyTWh();
        $entity->setTotalEnergyUse(500);
        $this->assertEquals(500, $entity->getTotalEnergyUse());
    }
}
