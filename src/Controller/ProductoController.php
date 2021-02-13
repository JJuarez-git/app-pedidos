<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Entity\Producto;
use App\Repository\CategoriaRepository;
use App\Repository\ProductoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

 /**
 * @Route("/producto")
 */
class ProductoController extends AbstractController
{
    /**
     * @Route("/", name="producto_index")
     */
    public function index(SessionInterface $session, ProductoRepository $productoRepository): Response
    {
        $cant = $session->get('cant_productos_cesta');
        $categorias = $this->getDoctrine()->getRepository(Categoria::class)->findBy([],[],4);
        $data_productos = [];

        foreach ($categorias as $categoria) {
            $productos = $productoRepository->findBy(['categoria' => $categoria], [], 8);
            $data_productos[] = ['categoria' => $categoria, 'productos' => $productos];
        }

        return $this->render('producto/producto.html.twig', [
            'controller_name' => 'Productos',
            'data_productos' => $data_productos, 
            'cant' => $cant
        ]);
    }

    /**
     * @Route("/show/{id}", name="producto_show", methods={"GET"})
     */
    public function show(SessionInterface $session, $id, ProductoRepository $productoRepository): Response
    {
        $cant = $session->get('cant_productos_cesta');

        return $this->render('producto/producto_show.html.twig', [
            'controller_name' => 'Productos',
            'p' => $productoRepository->find($id),
            'cant' => $cant
        ]);
    }

    /**
     * @Route("/cat/{id}", name="producto_cat", methods={"GET"})
     */
    public function cat(SessionInterface $session, ProductoRepository $productoRepository, CategoriaRepository $categoriaRepository, $id): Response {
        
        $cant = $session->get('cant_productos_cesta');

        return $this->render('producto/producto_cat.html.twig', [
            'controller_name' => 'Productos',
            'productos' => $productoRepository->productosPorCategoria($id),
            'categoria' => $categoriaRepository->find($id),
            'cant' => $cant
        ]);
    }
}
