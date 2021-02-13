<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categoria")
 */
class CategoriaController extends AbstractController
{
    /**
     * @Route("/", name="categoria_index")
     */
    public function index(SessionInterface $session, CategoriaRepository $categoriaRepository, EntityManagerInterface $em): Response
    {
        $cant = $session->get('cant_productos_cesta');

        return $this->render('categoria/categoria.html.twig', [
            'controller_name' => 'Categorías',
            'data_categorias' => $categoriaRepository->datosCategorias(),
            'cant' => $cant
        ]);
    }
}
