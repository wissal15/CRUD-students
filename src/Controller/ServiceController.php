<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    #[Route('/service', name: 'app_service')]
    public function index(): Response
    {
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }
   // #[Route('/show/{name}', name: 'show_service')]
   // public function showService($name): Response
    //{
     //return $this->render('service/showService.html.twig',[
       // 'n'=>$name
     //]);}
    
}
