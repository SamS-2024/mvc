<?php

namespace App\Controller;

use App\Entity\RenewableEnergyShare;
use App\Entity\RenewableEnergyTWh;
use App\Entity\EnergyIntensityPerGDP;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

/**
 * Trait for importing energy statistics from CSV files into the database.
 */
trait ProjectHelper
{
    /**
     * Reads a CSV file and returns raw rows (including header).
     *
     * @param string $fileName
     * @return array<int, array<int, string|null>>
     */
    private function readCsv(string $fileName): array
    {
        $file = __DIR__ . '/../data/' . $fileName;

        if (!file_exists($file)) {
            throw new Exception('CSV file not found: ' . $fileName);
        }

        // Öppnar en fil för läsning.
        $openFile = fopen($file, 'r');
        if ($openFile === false) {
            throw new Exception('Failed to open file: ' . $fileName);
        }

        $rows = [];
        // Läser en rad från filen som en array, delad med separator (; här).
        while (($data = fgetcsv($openFile, 0, ';')) !== false) {
            $rows[] = $data;
        }

        fclose($openFile);
        return $rows;
    }

    /**
     * Imports data from 'renewable_energy_share.csv' into the database.
     *
     * @param EntityManagerInterface $entityManager Doctrine entity manager.
     * @return void
     */
    public function importRenewableEnergyShare(
        EntityManagerInterface $entityManager
    ): void {
        $rows = $this->readCsv('renewable_energy_share.csv');
        $years = $rows[0];
        $data = array_slice($rows, 1);

        $entityManager->getConnection()->executeStatement('DELETE FROM renewable_energy_share');

        // Återställer auto-increment också.
        $entityManager->getConnection()->executeStatement("DELETE FROM sqlite_sequence WHERE name='renewable_energy_share'");

        $length = count($years);

        for ($i = 1; $i < $length; $i++) {
            $entity = new RenewableEnergyShare();
            // Konverterar till int från csv filen.
            $entity->setYear((int)$years[$i]);
            $entity->setTotal((int)$data[0][$i]);
            $entity->setHeatCoolingIndustry((int)$data[1][$i]);
            $entity->setElectricity((int)$data[2][$i]);
            $entity->setTransport((int)$data[3][$i]);

            $entityManager->persist($entity);
        }
        $entityManager->flush();
    }

    /**
     * Imports data from 'renewable_energy_TWh.csv' into the database.
     *
     * @param EntityManagerInterface $entityManager Doctrine entity manager.
     * @return void
     */
    public function importRenewableEnergyTWh(
        EntityManagerInterface $entityManager
    ): void {
        $rows = $this->readCsv('renewable_energy_TWh.csv');
        $years = $rows[0];
        $data = array_slice($rows, 1);

        $entityManager->getConnection()->executeStatement('DELETE FROM renewable_energy_twh');

        // Återställer auto-increment också.
        $entityManager->getConnection()->executeStatement("DELETE FROM sqlite_sequence WHERE name='renewable_energy_twh'");

        $length = count($years);

        for ($i = 1; $i <  $length; $i++) {
            $entity = new RenewableEnergyTWh();
            $entity->setYear((int)$years[$i]);
            $entity->setBiofuels((int)$data[0][$i]);
            $entity->setHydropower((int)$data[1][$i]);
            $entity->setWindPower((int)$data[2][$i]);
            $entity->setHeatPumps((int)$data[3][$i]);
            $entity->setSolarEnergy((int)$data[4][$i]);
            $entity->setTotal((int)$data[5][$i]);
            $entity->setStatisticalTransfer((int)$data[6][$i]);
            $entity->setTargetCalculation((int)$data[7][$i]);
            $entity->setTotalEnergyUse((int)$data[8][$i]);

            $entityManager->persist($entity);
        }
        $entityManager->flush();
    }

    /**
     * Imports data from 'energy_intensity.csv' into the database.
     *
     * @param EntityManagerInterface $entityManager Doctrine entity manager.
     * @return void
     */
    public function importEnergyIntensityPerGDP(
        EntityManagerInterface $entityManager
    ): void {
        $rows = $this->readCsv('energy_intensity.csv');
        $years = $rows[0];
        $data = array_slice($rows, 1);

        $entityManager->getConnection()->executeStatement('DELETE FROM energy_intensity_per_gdp');

        // Återställer auto-increment också.
        $entityManager->getConnection()->executeStatement("DELETE FROM sqlite_sequence WHERE name='energy_intensity_per_gdp'");

        $length = count($years);

        for ($i = 1; $i <  $length; $i++) {
            $entity = new EnergyIntensityPerGDP();
            $entity->setYear((int)$years[$i]);
            $entity->setIntensityChangePercent((float)$data[0][$i]);

            $entityManager->persist($entity);
        }
        $entityManager->flush();
    }
}
