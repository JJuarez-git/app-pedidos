<?php

namespace App\Controller;

use App\Entity\Pedido;
use App\Entity\PedidoProducto;
use App\Entity\Producto;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PedidoController extends AbstractController
{
    /**
     * @Route("/mispedidos", name="mispedidos")
     */
    public function index(SessionInterface $session): Response
    {
        $cant = $session->get('cant_productos_cesta');

        $pedidos = $this->getDoctrine()->getRepository(Pedido::class)->findBy(
            ['usuario' => $this->getUser()],
            ['fecha' => 'DESC']
        );

        $data_pedidos = [];

        foreach ($pedidos as $pedido) {
            $articulos =  $this->getDoctrine()->getRepository(PedidoProducto::class)->findBy(
                ['codPed' => $pedido->getId()]
            );

            $data_pedidos[] = ['pedido' => $pedido, 'articulos' => $articulos];
        }

        return $this->render('pedido/pedido.html.twig', [
            'controller_name' => 'Mis Pedidos',
            'cant' => $cant,
            'data' => $data_pedidos
        ]);
    }

    /**
     * @Route("/realizar_pedido", name="realizar_pedido")
     */
    public function realizarPedido(SessionInterface $session): Response
    {
        $cesta = $session->get('cesta');
        $total = $session->get('precio_total');
        $em = $this->getDoctrine()->getManager();
        

        if((empty($cesta)) || ($total < 10)){
            return $this->redirectToRoute('cesta');
        } else {
            
            $pedido = new Pedido();
            $pedido->setEnviado(0);
            $pedido->setUsuario($this->getUser());
            $pedido->setFecha(new DateTime());
            $pedido->setPrecio($total);
            $em->persist($pedido);        

            foreach ($cesta as $value) {
                $producto = $this->getDoctrine()->getRepository(Producto::class)->find($value['id']);
                $fila = new PedidoProducto();
                $fila->setCodPed($pedido);
                $fila->setCodProd($producto);
                $fila->setUnidades($value['cantidad']);
                $producto->setStock($producto->getStock() - $value['cantidad']);

                $em->persist($producto);
                $em->persist($fila);
            }

            try {
                $em->flush();
            } catch(Exception $e) {
                print_r($e);
            }

            $session->set('cesta', []);
            $session->set('cant_productos_cesta', 0);
    
        }

        return $this->render('pedido/realizar_pedido.html.twig', [
            'controller_name' => 'Pedido confirmado',
            'cant' => 0
        ]);
    }
}
