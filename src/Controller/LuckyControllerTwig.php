<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerTwig extends AbstractController
{

    #[Route("/lucky", name: "lucky")]
    public function lucky(): Response
    {
        $images = ['img1.webp', 'img2.webp', 'img3.webp', 'img4.webp', 'img5.webp', 'img6.webp'];
        $randomImage = $images[array_rand($images)]; // Slumpmässig bild
        $number = random_int(0, 100);

        $data = [
            'randomImage' => $randomImage,
            'number' => $number
        ];

        return $this->render('lucky.html.twig', $data);
}


    #[Route("/home", name: "home")]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

}