<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductoRepository;

class CestaController extends AbstractController
{
    /**
     * @Route("/cesta", name="cesta")
     */
    public function index(SessionInterface $session, ProductoRepository $productoRepository): Response
    {
        $session_cesta = $session->get('cesta'); 
        $cesta = $session_cesta;
        $vacia = false;
        $total = 0;

        if(empty($cesta)){
            $session->set('cesta', []);
            $cesta = [];
            $vacia = true;
        } else {
            $vacia = false;
            $elementos = [];
            foreach($cesta as $item){
                $elemento = $productoRepository->find($item["id"]);
                $elementos[] = [$elemento, $item["cantidad"]];
                $total += $elemento->getPrecio() * $item["cantidad"];
            }
            $cesta = $elementos;
        }

        $session->set('precio_total', $total);
        $session->set('cant_productos_cesta', sizeof($cesta));
        $cant = sizeof($cesta);

        return $this->render('cesta/cesta.html.twig', [
            'controller_name' => 'Cesta',
            'cesta' => $cesta,
            's_cesta' => $session_cesta,
            'vacia' => $vacia,
            'total' => $total,
            'cant' => $cant
        ]);
    }

    /**
     * @Route("/cesta_add/{id}/{cantidad}", name="cesta_add", methods={"GET"})
     */
    public function cestaAdd(SessionInterface $session, $id, $cantidad): Response {

        $cesta = $session->get('cesta');
        $cesta[] = ['id' => $id, 'cantidad' => $cantidad];
        $session->set('cesta', $cesta);

        $cant = $session->get('cant_productos_cesta');
        $session->set('cant_productos_cesta', $cant += 1);

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * @Route("/cesta_remove/{id}", name="cesta_remove", methods={"GET"})
     */
    public function cestaRemove(SessionInterface $session, $id): Response {

        $cesta = $session->get('cesta');
        unset($cesta[$id]);
        $reordenado = array_values($cesta);
        $session->set('cesta', $reordenado);

        return $this->redirectToRoute('cesta');
    }

    /** 
     * @Route("/cesta_remove_all", name="cesta_remove_all")
     */
    public function cestaRemoveAll(SessionInterface $session): Response {

        $session->set('cesta', []);

        return $this->redirectToRoute('cesta');
    }

}
