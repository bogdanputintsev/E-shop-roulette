<?php


namespace App\Services;


use App\Entity\Orders;
use App\Repository\OrdersRepository;
use App\Repository\ProductsKeysRepository;
use App\Repository\ProductsRepository;
use App\Repository\UsersRepository;

class ShopService
{
    public function buildOrder( $game_id, $pay_id, ProductsRepository $productsRepository, ProductsKeysRepository $keysRepository, UsersRepository $usersRepository, OrdersRepository $ordersRepository )
    {
        $product = $productsRepository->find($game_id);
        $key = $keysRepository->findUnused($game_id);
        $real = $usersRepository->find($pay_id)->getBalanceReal();
        $realBalance = $real - intval($_POST['amount']);
        $costs = $real - $realBalance;

        if ( count($key) > 0 && $product != null )
        {
            $key = $key[0];
            $order = new Orders();
            $order->setUserId($pay_id);
            $order->setCaseId(-2);
            $order->setProductId($game_id);
            $order->setInfo($key['value']);
            $order->setPrice($product->getPrice());
            $order->setCosts($costs);
            $order->setShowInTape(false);
            $order->setDate(new \DateTime());
            return $order;
        }
        return null;
    }

    public function updateUserInfo($game_id, $pay_id, $balance, $amount, UsersRepository $usersRepository, ProductsKeysRepository $keysRepository)
    {
        $real = $usersRepository->find($pay_id)->getBalanceReal();
        $realBalance = $real - intval($_POST['amount']);
        $key = $keysRepository->findUnused($game_id);

        $usersRepository->updateBalance($pay_id, $balance - $amount, $realBalance);
        $keysRepository->Use($key[0]['id']);
        return "SUCCESS";
    }

}