<?php

namespace App\Controller;
use App\Entity\RenewableEnergyShare;
use App\Controller\ProjectHelpers;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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

     #[Route("proj/session", name: "show_proj_session")]
    public function session(
        SessionInterface $session
    ): Response {

        $data = [
            "session" => $session->all()
        ];

        return $this->render('Project/session.html.twig', $data);
    }

    #[Route("proj/session/delete", name: "delete_proj_session")]
    public function deleteSession(
        SessionInterface $session
    ): Response {

        $session->clear();

        $this->addFlash(
            'notice',
            'The session is deleted!'
        );

        return $this->redirectToRoute('show_proj_session');
    }

    #[Route('/proj/import-csv', name: 'proj_import_csv')]
    public function importAll(
        EntityManagerInterface $entityManager
        ): Response
    {
        $this->importRenewableEnergyShare($entityManager);
        $this->importRenewableEnergyTWh($entityManager);
        $this->importEnergyIntensityPerGDP($entityManager);
        return new Response('Import klar');

    }
}
