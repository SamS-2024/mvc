<?php

namespace App\Controller;

use App\Repository\RenewableEnergyShareRepository;
use App\Repository\RenewableEnergyTWhRepository;
use App\Repository\EnergyIntensityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ControllerJsonProject extends AbstractController
{
    // Översikt över routes med länkar. POST-routen testas via sök-formuläret på sidan.
    #[Route("/proj/api", name: "api-proj")]
    public function apiOverview(): Response
    {
        $data = [
            '/proj/api' => 'Huvudsidan.',
            '/proj/api/energy-share-el' => 'Förnybar energi för el och transporter.',
            '/proj/api/energy-share-total' => 'Förnybar energi som totalt samt värme, kyla, industri..mm som värde.',
            '/proj/api/energy-intensity' => 'Energi-intensitet i procent.',
            '/proj/api/energy-TWh' => 'Förnybar energi i TWh',
            '/proj/api/TWh-target' => 'Visar överförd energi till Norge och målberäkningen',
            '/proj/api/TWh-total' => 'Total förnybar energiproduktion och total energianvändning i TWh.',
            '/proj/search' => 'Formulär för att testa POST-routen.'

        ];

        return $this->render('Project/api-proj.html.twig', ['data' => $data]);
    }

    #[Route('/proj/api/energy-share-total', name: 'api_energy_share_total')]
    public function getEnergyShare(
        RenewableEnergyShareRepository $repo
    ): Response {
        $data = $repo->findAll();
        $result = [];

        foreach ($data as $item) {
            $result[] = [
                'year' => $item->getYear(),
                'total' => $item->getTotal(),
                'value' => $item->getHeatCoolingIndustry(),
            ];
        }

        return $this->createJsonResponse($result);
    }

    #[Route('/proj/api/energy-intensity', name: 'api_energy_intensity')]
    public function getEnergyIntensity(
        EnergyIntensityRepository $repo
    ): Response {
        $data = $repo->findAll();
        $result = [];

        foreach ($data as $item) {
            $result[] = [
                'year' => $item->getYear(),
                'value' => $item->getIntensityChangePercent()
            ];
        }

        return $this->createJsonResponse($result);
    }

    // Detaljerad api
    // Den här route visar endast el och transporter för enklare API-användning i frontend.
    #[Route('/proj/api/energy-share-el', name: 'api_energy_share-el')]
    public function getEnergyShareEL(
        RenewableEnergyShareRepository $repo
    ): Response {
        $data = $repo->findAll();
        $result = [];

        foreach ($data as $item) {
            $result[] = [
                'year' => $item->getYear(),
                'el' => $item->getElectricity(),
                'transport' => $item->getTransport(),
            ];
        }

        return $this->createJsonResponse($result);
    }


    #[Route('/proj/api/energy-TWh', name: 'api_energy_TWh')]
    public function getEnergyTWh(
        RenewableEnergyTWhRepository $repo
    ): Response {
        $data = $repo->findAll();
        $result = [];

        foreach ($data as $item) {
            $result[] = [
                'year' => $item->getYear(),
                'bio' => $item->getBiofuels(),
                'hydro' => $item->getHydropower(),
                'wind' => $item->getWindPower(),
                'heat' => $item->getHeatPumps(),
                'solar' => $item->getSolarEnergy(),
            ];
        }

        return $this->createJsonResponse($result);
    }

    #[Route('/proj/api/TWh-total', name: 'api_TWh_total')]
    public function getTotalInTWh(
        RenewableEnergyTWhRepository $repo
    ): Response {
        $data = $repo->findAll();
        $result = [];

        foreach ($data as $item) {
            $result[] = [
                'year' => $item->getYear(),
                'TWh-total' => $item->getTotal(),
                'total-use' => $item->getTotalEnergyUse(),
            ];
        }

        return $this->createJsonResponse($result);
    }

    #[Route('/proj/api/TWh-target', name: 'api_TWh_target')]
    public function getTarget(
        RenewableEnergyTWhRepository $repo
    ): Response {
        $data = $repo->findAll();
        $result = [];

        foreach ($data as $item) {
            $result[] = [
                'year' => $item->getYear(),
                'statistical' => $item->getStatisticalTransfer(),
                'target' => $item->getTargetCalculation(),
            ];
        }

        return $this->createJsonResponse($result);
    }

    // En route för filtrering
    #[Route('/proj/api/energy-TWh-filter', name: 'api_energy_TWh_filter', methods: ['POST'])]
    public function filterTWhByYearAndType(
        Request $request,
        RenewableEnergyTWhRepository $repo
    ): Response {
        $json = $request->getContent();
        $data = json_decode($json, true);

        /** @var array{year?: int, type?: string} $data */
        $year = $data['year'] ?? null;
        $type = $data['type'] ?? null;

        $result = [];

        foreach ($repo->findAll() as $item) {
            if ($item->getYear() == $year) {
                $value = null;
                switch ($type) {
                    case 'bio': $value = $item->getBiofuels();
                        break;
                    case 'hydro': $value = $item->getHydropower();
                        break;
                    case 'wind': $value = $item->getWindPower();
                        break;
                    case 'heat': $value = $item->getHeatPumps();
                        break;
                    case 'solar': $value = $item->getSolarEnergy();
                        break;
                }
                if ($value !== null) {
                    $result[] = [
                        'year' => $item->getYear(),
                        $type => $value,
                    ];
                }
            }
        }

        return $this->createJsonResponse($result);
    }

    private function createJsonResponse(array $data): Response
    {
        $response = $this->json($data);
        $response->setEncodingOptions(
        $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
