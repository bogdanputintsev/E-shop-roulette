<?php

namespace App\Controller;


use App\Interfaces\IOrdersRepository;
use App\Interfaces\IProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrdersController extends AbstractController
{
    /**
     * @Route("/orders", name="orders")
     * @param IOrdersRepository $ordersRepository
     * @param IProductsRepository $productsRepository
     * @return Response
     */
    public function index(IOrdersRepository $ordersRepository, IProductsRepository $productsRepository)
    {
        $list = $ordersRepository->findByUser($this->get('session')->get('id'));

        return $this->render('orders/index.html.twig', [
            'controller_name' => 'OrdersController',
            'page' => 'orders',
            'avatar' =>   $this->get('session')->get('avatar'),
            'uid' => 'none' ? $this->get('session')->get('id') == "" : $this->get('session')->get('id'),
            'username' =>  $this->get('session')->get('username'),
            'balance' => $this->get('session')->get('balance'),
            'orders' => $list
        ]);
    }
}
