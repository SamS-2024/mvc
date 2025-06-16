<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class RenewableEnergyTWh
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    /** @phpstan-ignore-next-line */
    private ?int $id = null;

    #[ORM\Column(type:"integer")]
    private ?int $year = null;

    #[ORM\Column(type:"integer", nullable:true)]
    private ?int $biofuels = null;

    #[ORM\Column(type:"integer", nullable:true)]
    private ?int $hydropower = null;

    #[ORM\Column(type:"integer", nullable:true)]
    private ?int $windPower = null;

    #[ORM\Column(type:"integer", nullable:true)]
    private ?int $heatPumps = null;

    #[ORM\Column(type:"integer", nullable:true)]
    private ?int $solarEnergy = null;

    #[ORM\Column(type:"integer", nullable:true)]
    private ?int $total = null;

    #[ORM\Column(type:"integer", nullable:true)]
    private ?int $statisticalTransfer = null;

    #[ORM\Column(type:"integer", nullable:true)]
    private ?int $targetCalculation = null;

    #[ORM\Column(type:"integer", nullable:true)]
    private ?int $totalEnergyUse = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getYear(): ?int
    {
        return $this->year;
    }
    public function setYear(int $year): static
    {
        $this->year = $year;
        return $this;
    }
    public function getBiofuels(): ?int
    {
        return $this->biofuels;
    }
    public function setBiofuels(?int $value): static
    {
        $this->biofuels = $value;
        return $this;
    }
    public function getHydropower(): ?int
    {
        return $this->hydropower;
    }
    public function setHydropower(?int $value): static
    {
        $this->hydropower = $value;
        return $this;
    }
    public function getWindPower(): ?int
    {
        return $this->windPower;
    }
    public function setWindPower(?int $value): static
    {
        $this->windPower = $value;
        return $this;
    }
    public function getHeatPumps(): ?int
    {
        return $this->heatPumps;
    }
    public function setHeatPumps(?int $value): static
    {
        $this->heatPumps = $value;
        return $this;
    }
    public function getSolarEnergy(): ?int
    {
        return $this->solarEnergy;
    }
    public function setSolarEnergy(?int $value): static
    {
        $this->solarEnergy = $value;
        return $this;
    }
    public function getTotal(): ?int
    {
        return $this->total;
    }
    public function setTotal(?int $value): static
    {
        $this->total = $value;
        return $this;
    }
    public function getStatisticalTransfer(): ?int
    {
        return $this->statisticalTransfer;
    }
    public function setStatisticalTransfer(?int $value): static
    {
        $this->statisticalTransfer = $value;
        return $this;
    }
    public function getTargetCalculation(): ?int
    {
        return $this->targetCalculation;
    }
    public function setTargetCalculation(?int $value): static
    {
        $this->targetCalculation = $value;
        return $this;
    }
    public function getTotalEnergyUse(): ?int
    {
        return $this->totalEnergyUse;
    }
    public function setTotalEnergyUse(?int $value): static
    {
        $this->totalEnergyUse = $value;
        return $this;
    }
}
