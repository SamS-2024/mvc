<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class EnergyIntensityPerGDP
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    /** @phpstan-ignore-next-line */
    private ?int $id = null;

    #[ORM\Column(type:"integer")]
    private ?int $year = null;

    #[ORM\Column(type:"float", nullable:true)]
    // private ?float $percentChange = null;
    private ?float $intensityChangePercent = null;


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
    public function getIntensityChangePercent(): ?float
    {
        return $this->intensityChangePercent;
    }
    public function setIntensityChangePercent(?float $value): static
    {
        $this->intensityChangePercent = $value;
        return $this;
    }
}
