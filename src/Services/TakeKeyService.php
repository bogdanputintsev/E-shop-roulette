<?php


namespace App\Services;


use Symfony\Component\HttpFoundation\Response;

class TakeKeyService
{

    public function FindTwoKeys(\App\Interfaces\IOrdersRepository $ordersRepository, \App\Interfaces\IUsersRepository $usersRepository, \App\Interfaces\IProductsKeysRepository $productsKeysRepository)
    {
        $keys = $productsKeysRepository->findUnused(4);

        if (count($keys) < 2) {
            return new Response("[Выдача ключа]: Ключ не был найден");
        }

        shuffle($keys);
        $key1 = $keys[0]['value'];
        $key2 = $keys[1]['value'];
        $value = $key1 . '<br>' . $key2 . '<br>';

        return $value;
    }

    public function FindKey(\App\Interfaces\IOrdersRepository $ordersRepository, \App\Interfaces\IUsersRepository $usersRepository, \App\Interfaces\IProductsKeysRepository $productsKeysRepository)
    {
        $key = $productsKeysRepository->findUnused($_GET['result']);

        if(count($key) == 0)
        {
            return "[Выдача ключа]: Ключ не был найден";
        }

        return $key[0]['value'];
    }
}