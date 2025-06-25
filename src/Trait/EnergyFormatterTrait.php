<?php

namespace App\Trait;

use App\Entity\EnergyIntensityPerGDP;
use App\Entity\RenewableEnergyShare;
use App\Entity\RenewableEnergyTWh;

trait EnergyFormatterTrait
{
    /**
    * @param RenewableEnergyShare[] $items
    * @return array<int, array<string, int|null>>
    */
    private function formatEnergyShareTotal(array $items): array
    {
        $result = [];
        foreach ($items as $item) {
            $result[] = [
                'year' => $item->getYear(),
                'total' => $item->getTotal(),
                'value' => $item->getHeatCoolingIndustry(),
            ];
        }
        return $result;
    }

    /**
     * @param RenewableEnergyShare[] $items
     * @return array<int, array{year: int|null, el: int|null, transport: int|null}>
     */
    private function formatEnergyShareEL(array $items): array
    {
        $result = [];
        foreach ($items as $item) {
            $result[] = [
                'year' => $item->getYear(),
                'el' => $item->getElectricity(),
                'transport' => $item->getTransport(),
            ];
        }
        return $result;
    }

    /**
     * @param EnergyIntensityPerGDP[] $items
     * @return array<int, array{year: int|null, value: float|null}>
     */
    private function formatEnergyIntensity(array $items): array
    {
        $result = [];
        foreach ($items as $item) {
            $result[] = [
                'year' => $item->getYear(),
                'value' => $item->getIntensityChangePercent(),
            ];
        }
        return $result;
    }

    /**
     * @param RenewableEnergyTWh[] $items
     * @return array<int, array{
     * year: int|null, bio: int|null, hydro: int|null, wind: int|null, heat: int|null, solar: int|null
     * }>
     */
    private function formatEnergyTWh(array $items): array
    {
        $result = [];
        foreach ($items as $item) {
            $result[] = [
                'year' => $item->getYear(),
                'bio' => $item->getBiofuels(),
                'hydro' => $item->getHydropower(),
                'wind' => $item->getWindPower(),
                'heat' => $item->getHeatPumps(),
                'solar' => $item->getSolarEnergy(),
            ];
        }
        return $result;
    }

    /**
     * @param RenewableEnergyTWh[] $items
     * @return array<int, array{year: int|null, TWh-total: int|null, total-use: int|null}>
     */
    private function formatTotalInTWh(array $items): array
    {
        $result = [];
        foreach ($items as $item) {
            $result[] = [
                'year' => $item->getYear(),
                'TWh-total' => $item->getTotal(),
                'total-use' => $item->getTotalEnergyUse(),
            ];
        }
        return $result;
    }

    /**
     * @param RenewableEnergyTWh[] $items
     * @return array<int, array{year: int|null, statistical: int|null, target: int|null}>
     */
    private function formatTarget(array $items): array
    {
        $result = [];
        foreach ($items as $item) {

            $result[] = [
                'year' => $item->getYear(),
                'statistical' => $item->getStatisticalTransfer(),
                'target' => $item->getTargetCalculation(),
            ];
        }
        return $result;
    }

    /**
     * @param RenewableEnergyTWh[] $items
     * @param int|null $year
     * @param string|null $type
     * @return list<array<string, int|null>>
     */
    private function filterTWhDataByYearAndType(array $items, ?int $year, ?string $type): array
    {
        $result = [];

        foreach ($items as $item) {
            if ($item->getYear() === $year) {
                $value = match ($type) {
                    'bio' => $item->getBiofuels(),
                    'hydro' => $item->getHydropower(),
                    'wind' => $item->getWindPower(),
                    'heat' => $item->getHeatPumps(),
                    'solar' => $item->getSolarEnergy(),
                    default => null,
                };

                if ($value !== null) {
                    $result[] = [
                        'year' => $item->getYear(),
                        $type => $value,
                    ];
                }
            }
        }

        return $result;
    }

}
