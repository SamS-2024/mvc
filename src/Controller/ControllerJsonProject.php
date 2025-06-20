<?php

namespace App\Controller;

use App\Entity\RenewableEnergyShare;
use App\Entity\RenewableEnergyTWh;
use App\Entity\EnergyIntensityPerGDP;
use App\Repository\RenewableEnergyShareRepository;
use App\Repository\RenewableEnergyTWhRepository;
use App\Repository\EnergyIntensityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ControllerJsonProject extends AbstractController
{


#[Route("/proj/api", name: "api-proj")]
    public function apiOverview(): Response
    {
        $data = [
            '/proj/api' => 'Huvudsidan.',
            '/proj/api/energy-share-el' => 'Förnybar energi för el och transporter.',
            '/proj/api/energy-share-total' => 'Förnybar energi som totalt samt värme, kyla, industri..mm som värde.',
            '/proj/api/energy-intensity' => 'Energi-intensitet i procent.',

        ];

        return $this->render('Project/api-proj.html.twig', ['data' => $data]);
    }
    #[Route('/proj/api/energy-share-total', name: 'api_energy_share_total')]
    public function getEnergyShare(
    RenewableEnergyShareRepository $repo
    ): Response
{
    $data = $repo->findAll();
    $result = [];

    foreach($data as $item) {
    $result[] = [
        'year' => $item->getYear(),
        'total' => $item->getTotal(),
        'value' => $item->getHeatCoolingIndustry(),
        // 'el' => $item->getElectricity(),
        // 'transport' => $item->getTransport(),
    ];
}

     $response = $this->json($result);
    $response->setEncodingOptions(
        $response->getEncodingOptions() | JSON_PRETTY_PRINT
    );
    return $response;

    }

    #[Route('/proj/api/energy-intensity', name: 'api_energy_intensity')]
    public function getEnergyIntensity(
        EnergyIntensityRepository $repo
        ): Response
    {
        $data = $repo->findAll();
        $result = [];

        foreach($data as $item) {
        $result[] = [
            'year' => $item->getYear(),
            'value' => $item->getIntensityChangePercent()
        ];
    }

     $response = $this->json($result);
    $response->setEncodingOptions(
        $response->getEncodingOptions() | JSON_PRETTY_PRINT
    );
    return $response;

    }

    // Detaljerad api
    // Den här route visar endast el och transporter för enklare API-användning i frontend.
    #[Route('/proj/api/energy-share-el', name: 'api_energy_share-el')]
    public function getEnergyShareEL(
    RenewableEnergyShareRepository $repo
    ): Response
{
    $data = $repo->findAll();
    $result = [];

    foreach($data as $item) {
    $result[] = [
        'year' => $item->getYear(),
        // 'total' => $item->getTotal(),
        // 'value' => $item->getHeatCoolingIndustry(),
        'el' => $item->getElectricity(),
        'transport' => $item->getTransport(),
    ];
}
$response = $this->json($result);
    $response->setEncodingOptions(
        $response->getEncodingOptions() | JSON_PRETTY_PRINT
    );
    return $response;

    }


}