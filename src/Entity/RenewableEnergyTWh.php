<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class RenewableEnergyTWh
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    /** @var int|null Primary key */
    /** @phpstan-ignore-next-line */
    private ?int $id = null;

    /** @var int|null Year of data */
    #[ORM\Column(type:"integer")]
    private ?int $year = null;

    /** @var int|null Energy from biofuels (TWh) */
    #[ORM\Column(type:"integer", nullable:true)]
    private ?int $biofuels = null;

    /** @var int|null Energy from hydropower (TWh) */
    #[ORM\Column(type:"integer", nullable:true)]
    private ?int $hydropower = null;

    /** @var int|null Energy from wind power (TWh) */
    #[ORM\Column(type:"integer", nullable:true)]
    private ?int $windPower = null;

    /** @var int|null Energy from heat pumps (TWh) */
    #[ORM\Column(type:"integer", nullable:true)]
    private ?int $heatPumps = null;

    /** @var int|null Energy from solar (TWh) */
    #[ORM\Column(type:"integer", nullable:true)]
    private ?int $solarEnergy = null;

    /** @var int|null Total renewable energy (TWh) */
    #[ORM\Column(type:"integer", nullable:true)]
    private ?int $total = null;

    /** @var int|null Statistical transfer (TWh) */
    #[ORM\Column(type:"integer", nullable:true)]
    private ?int $statisticalTransfer = null;

    /** @var int|null Value used for target calculation (TWh) */
    #[ORM\Column(type:"integer", nullable:true)]
    private ?int $targetCalculation = null;

    /** @var int|null Total energy use (TWh) */
    #[ORM\Column(type:"integer", nullable:true)]
    private ?int $totalEnergyUse = null;

    /**
     * Get the entity ID.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the year.
     *
     * @return int|null
     */
    public function getYear(): ?int
    {
        return $this->year;
    }

    /**
     * Set the year.
     *
     * @param int $year
     * @return static
     */
    public function setYear(int $year): static
    {
        $this->year = $year;
        return $this;
    }
    /**
     * Get biofuels in TWh.
     *
     * @return int|null
     */
    public function getBiofuels(): ?int
    {
        return $this->biofuels;
    }

    /**
     * Set biofuels in TWh.
     *
     * @param int|null $value
     * @return static
     */
    public function setBiofuels(?int $value): static
    {
        $this->biofuels = $value;
        return $this;
    }

    /**
     * Get hydropower in TWh.
     *
     * @return int|null
     */
    public function getHydropower(): ?int
    {
        return $this->hydropower;
    }
    /**
     * Set hydropower in TWh.
     *
     * @param int|null $value
     * @return static
     */
    public function setHydropower(?int $value): static
    {
        $this->hydropower = $value;
        return $this;
    }
    /**
     * Get wind power in TWh.
     *
     * @return int|null
     */
    public function getWindPower(): ?int
    {
        return $this->windPower;
    }
    /**
     * Set wind power in TWh.
     *
     * @param int|null $value
     * @return static
     */
    public function setWindPower(?int $value): static
    {
        $this->windPower = $value;
        return $this;
    }

    /**
     * Get heat pumps in TWh.
     *
     * @return int|null
     */
    public function getHeatPumps(): ?int
    {
        return $this->heatPumps;
    }

    /**
     * Set heat pumps in TWh.
     *
     * @param int|null $value
     * @return static
     */
    public function setHeatPumps(?int $value): static
    {
        $this->heatPumps = $value;
        return $this;
    }

    /**
     * Get solar energy in TWh.
     *
     * @return int|null
     */
    public function getSolarEnergy(): ?int
    {
        return $this->solarEnergy;
    }

    /**
     * Set solar energy in TWh.
     *
     * @param int|null $value
     * @return static
     */
    public function setSolarEnergy(?int $value): static
    {
        $this->solarEnergy = $value;
        return $this;
    }

    /**
     * Get total renewable energy in TWh.
     *
     * @return int|null
     */
    public function getTotal(): ?int
    {
        return $this->total;
    }

    /**
     * Set total renewable energy in TWh.
     *
     * @param int|null $value
     * @return static
     */
    public function setTotal(?int $value): static
    {
        $this->total = $value;
        return $this;
    }

    /**
     * Get statistical transfer in TWh.
     *
     * @return int|null
     */
    public function getStatisticalTransfer(): ?int
    {
        return $this->statisticalTransfer;
    }

    /**
     * Set statistical transfer in TWh.
     *
     * @param int|null $value
     * @return static
     */
    public function setStatisticalTransfer(?int $value): static
    {
        $this->statisticalTransfer = $value;
        return $this;
    }
    /**
     * Get value used for target calculation in TWh.
     *
     * @return int|null
     */
    public function getTargetCalculation(): ?int
    {
        return $this->targetCalculation;
    }
    /**
     * Set value used for target calculation in TWh.
     *
     * @param int|null $value
     * @return static
     */
    public function setTargetCalculation(?int $value): static
    {
        $this->targetCalculation = $value;
        return $this;
    }

    /**
     * Get total energy use in TWh.
     *
     * @return int|null
     */
    public function getTotalEnergyUse(): ?int
    {
        return $this->totalEnergyUse;
    }

    /**
     * Set total energy use in TWh.
     *
     * @param int|null $value
     * @return static
     */
    public function setTotalEnergyUse(?int $value): static
    {
        $this->totalEnergyUse = $value;
        return $this;
    }
}
