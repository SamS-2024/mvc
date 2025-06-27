<?php

namespace App\Controller;

use App\Repository\RenewableEnergyShareRepository;
use App\Repository\RenewableEnergyTWhRepository;
use App\Repository\EnergyIntensityRepository;
use App\Trait\EnergyFormatterTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ControllerJsonProject extends AbstractController
{
    use EnergyFormatterTrait;

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

        $result = $this->formatEnergyShareTotal($repo->findAll());
        return $this->createJsonResponse($result);

    }


    #[Route('/proj/api/energy-intensity', name: 'api_energy_intensity')]
    public function getEnergyIntensity(
        EnergyIntensityRepository $repo
    ): Response {

        $result = $this->formatEnergyIntensity($repo->findAll());
        return $this->createJsonResponse($result);
    }


    // Den här routen visar endast el och transporter för enklare API-användning.
    #[Route('/proj/api/energy-share-el', name: 'api_energy_share-el')]
    public function getEnergyShareEL(
        RenewableEnergyShareRepository $repo
    ): Response {
        $result = $this->formatEnergyShareEL($repo->findAll());
        return $this->createJsonResponse($result);
    }

    #[Route('/proj/api/energy-TWh', name: 'api_energy_TWh')]
    public function getEnergyTWh(
        RenewableEnergyTWhRepository $repo
    ): Response {

        $result = $this->formatEnergyTWh($repo->findAll());
        return $this->createJsonResponse($result);
    }

    #[Route('/proj/api/TWh-total', name: 'api_TWh_total')]
    public function getTotalInTWh(
        RenewableEnergyTWhRepository $repo
    ): Response {


        $result = $this->formatTotalInTWh($repo->findAll());

        return $this->createJsonResponse($result);
    }

    #[Route('/proj/api/TWh-target', name: 'api_TWh_target')]
    public function getTarget(
        RenewableEnergyTWhRepository $repo
    ): Response {


        $result = $this->formatTarget($repo->findAll());
        return $this->createJsonResponse($result);
    }

    #[Route('/proj/api/energy-TWh-filter', name: 'api_energy_TWh_filter', methods: ['POST'])]
    public function filterTWhByYearAndType(
        Request $request,
        RenewableEnergyTWhRepository $repo
    ): Response {
        $data = json_decode($request->getContent(), true);
        /** @var array{year: int, type: string} $data */
        $year = $data['year'];
        $type = $data['type'];

        $result = $this->filterTWhDataByYearAndType($repo->findAll(), $year, $type);

        return $this->createJsonResponse($result);
    }


    /**
     * @param array<int, mixed> $data
     */
    private function createJsonResponse(array $data): Response
    {
        $response = $this->json($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
