<?php

namespace App\Controller;

use App\Trait\ProjectHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    use ProjectHelper;

    #[Route("/proj", name: "proj")]
    public function proj(): Response
    {

        return $this->render('Project/proj.html.twig');
    }

    #[Route("/proj/energy", name: "proj_energy")]
    public function energyInTwh(): Response
    {

        return $this->render('Project/proj-energy.html.twig');
    }

    #[Route("/proj/about", name: "about_proj")]
    public function aboutProj(): Response
    {

        return $this->render('Project/about-proj.html.twig');
    }

    #[Route("/proj/about/database", name: "proj_about_database")]
    public function projDatabase(): Response
    {

        return $this->render('Project/proj-database.html.twig');
    }


    #[Route("/proj/search", name: "search_proj")]
    public function searchProj(): Response
    {

        return $this->render('Project/search.html.twig');
    }
    // Route som rensar och fyller databasen med data från CSV-filer.
    #[Route('/proj/import-csv', name: 'proj_import_csv')]
    public function importAll(
        EntityManagerInterface $entityManager
    ): Response {
        $this->importRenewableEnergyShare($entityManager);
        $this->importRenewableEnergyTWh($entityManager);
        $this->importEnergyIntensityPerGDP($entityManager);
        return new Response('Import klar');

    }
}
