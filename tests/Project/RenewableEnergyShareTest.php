<?php

namespace App\Tests\Project;

use App\Entity\RenewableEnergyShare;
use PHPUnit\Framework\TestCase;

class RenewableEnergyShareTest extends TestCase
{
    public function testSetAndGetYear(): void
    {
        $entity = new RenewableEnergyShare();
        $entity->setYear(2020);
        $this->assertEquals(2020, $entity->getYear());
    }

    public function testSetAndGetTotal(): void
    {
        $entity = new RenewableEnergyShare();
        $entity->setTotal(45);
        $this->assertEquals(45, $entity->getTotal());
    }

    public function testSetAndGetIndustryValues(): void
    {
        $entity = new RenewableEnergyShare();
        $entity->setHeatCoolingIndustry(70);
        $this->assertEquals(70, $entity->getHeatCoolingIndustry());
    }

    public function testSetAndGetElectricity(): void
    {
        $entity = new RenewableEnergyShare();
        $entity->setElectricity(70);
        $this->assertEquals(70, $entity->getElectricity());
    }

    public function testSetAndGetTransport(): void
    {
        $entity = new RenewableEnergyShare();
        $entity->setTransport(70);
        $this->assertEquals(70, $entity->getTransport());
    }
}
