<?php

namespace App\Controller;


use App\Interfaces\IProductsKeysRepository;
use App\Interfaces\IProductsRepository;
use App\Interfaces\IUsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{

    /**
     * @Route("/shop", name="shop")
     * @param IProductsRepository $productsRepository
     * @return Response
     */
    public function index(IProductsRepository $productsRepository)
    {
        $products = $productsRepository->findAllProductsInShop();
        $accounts = $productsRepository->findAllAccountsInShop();

        return $this->render('shop/index.html.twig', [
            'controller_name' => 'ShopController',
            'page' => 'shop',
            'avatar' =>   $this->get('session')->get('avatar'),
            'uid' => 'none' ? $this->get('session')->get('id') == "" : $this->get('session')->get('id'),
            'username' =>  $this->get('session')->get('username'),
            'balance' => $this->get('session')->get('balance'),
            'products' => $products,
            'accounts' => $accounts
        ]);
    }

    /**
     * @Route("/purchase/{id}", name="purchase")
     * @param Request $request
     * @param IUsersRepository $usersRepository
     * @param IProductsRepository $productsRepository
     * @param IProductsKeysRepository $keysRepository
     * @return Response
     */
    public function purchase(Request $request, IUsersRepository $usersRepository, IProductsRepository $productsRepository, IProductsKeysRepository $keysRepository)
    {
        $keysAvailable = $keysRepository->isAvailable($request->get("id"));
        $game = $productsRepository->findGame($request->get('id'));
        if($game == null)
        {
            return $this->redirect('404.html.twig');
        }

        return $this->render('shop/purchase.html.twig', [
            'controller_name' => 'ShopController',
            'page' => 'purchase',
            'avatar' =>   $this->get('session')->get('avatar'),
            'uid' => 'none' ? $this->get('session')->get('id') == "" : $this->get('session')->get('id'),
            'username' =>  $this->get('session')->get('username'),
            'balance' => $this->get('session')->get('id') != "" ? $usersRepository->find($this->get('session')->get('id'))->getBalance() : 0,
            'keys_available' => $keysAvailable,
            'game' => $game
        ]);
    }
}
