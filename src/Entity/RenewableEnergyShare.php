<?php

namespace App\Entity;

use App\Repository\RenewableEnergyShareRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RenewableEnergyShareRepository::class)]
#[ORM\Table(name: "renewable_energy_share")]
class RenewableEnergyShare
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    /** @phpstan-ignore-next-line */
    private ?int $id = null;

    #[ORM\Column(type:"integer")]
    private ?int $year = null;

    #[ORM\Column(type:"integer", nullable:true)]
    private ?int $total = null;

    #[ORM\Column(type:"integer", nullable:true)]
    private ?int $heatCoolingIndustry = null;

    #[ORM\Column(type:"integer", nullable:true)]
    private ?int $electricity = null;

    #[ORM\Column(type:"integer", nullable:true)]
    private ?int $transport = null;

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
    public function getTotal(): ?int
    {
        return $this->total;
    }
    public function setTotal(?int $total): static
    {
        $this->total = $total;
        return $this;
    }
    public function getHeatCoolingIndustry(): ?int
    {
        return $this->heatCoolingIndustry;
    }
    public function setHeatCoolingIndustry(?int $value): static
    {
        $this->heatCoolingIndustry = $value;
        return $this;
    }
    public function getElectricity(): ?int
    {
        return $this->electricity;
    }
    public function setElectricity(?int $value): static
    {
        $this->electricity = $value;
        return $this;
    }
    public function getTransport(): ?int
    {
        return $this->transport;
    }
    public function setTransport(?int $value): static
    {
        $this->transport = $value;
        return $this;
    }
}
