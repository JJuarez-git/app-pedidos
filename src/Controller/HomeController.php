<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(SessionInterface $session): Response
    {   
        $cesta = $session->get('cesta'); 

        if(empty($cesta)){
            $session->set('cant_productos_cesta', 0);
            $cant = 0;
        } else{
            $cant = sizeof($cesta);
        }

        return $this->render('home/home.html.twig', [
            'controller_name' => 'Home',
            'cant' => $cant
        ]);
    }
}
