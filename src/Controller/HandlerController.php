<?php

namespace App\Controller;

use App\Entity\UsersOrders;
use App\Interfaces\ICasesRepository;
use App\Interfaces\IOrdersRepository;
use App\Interfaces\IProductsKeysRepository;
use App\Interfaces\IProductsRepository;
use App\Interfaces\IUsersRepository;
use App\Services\ShopService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HandlerController extends AbstractController
{
    /**
     * @Route("/handler/buy/", name="buy")
     * @param ShopService $shopService
     * @param IProductsRepository $productsRepository
     * @param IProductsKeysRepository $keysRepository
     * @param IUsersRepository $usersRepository
     * @param IOrdersRepository $ordersRepository
     * @return Response
     */
    public function buyGame(ShopService $shopService, IProductsRepository $productsRepository, IProductsKeysRepository $keysRepository, IUsersRepository $usersRepository, IOrdersRepository $ordersRepository)
    {
        $order = $shopService->buildOrder($_POST['game_id'], $_POST['pay_id'], $productsRepository, $keysRepository, $usersRepository, $ordersRepository);

        if ( $order == null ){
            return new Response("Failed to find keys");
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($order);
        $em->flush();

        $balance = $usersRepository->find($_POST['pay_id'])->getBalance();
        $res = $shopService->updateUserInfo($_POST['game_id'], $_POST['pay_id'], $balance, $_POST['amount'], $usersRepository, $keysRepository);
        return new Response($res);
    }

    /**
     * @Route("/handler/livetape", name="livetape")
     * @param IOrdersRepository $ordersRepository
     * @return Response
     * @throws Exception
     */
    public function livetape(IOrdersRepository $ordersRepository)
    {
        $result = $ordersRepository->livetape();

        if(($rows = count($result)) > 0 )
        {
            $result['global'] = intval($ordersRepository->winningsCount());
            $result['length'] = $rows;
            for ( $i = 0; $i < $rows; $i++ )
            {
                $result[$i]['date'] = $this->getTime($result[$i]['date']);
            }
        }
        return new Response(json_encode($result));
    }

    private function getTime($date)
    {
        $time = $date;
        $timeNow = date_create();
        $difference = $timeNow->diff($time);

        if($difference->d >= 1){
            return $this->declension($difference->d, 'days');
        }
        else if($difference->h >= 1) {
            return $this->declension($difference->h, 'hours');
        }
        else if($difference->i >= 1) {
            return $this->declension($difference->i, 'minutes');
        }
        else {
            return $this->declension($difference->s, 'seconds');
        }
    }

    private function declension($digit, $type)
    {
        $str = array();
        if($type == 'days') {
            $str = ['день', 'дня', 'дней'];
        }
        else if($type == 'hours') {
            $str = ['час', 'часа', 'часов'];
        }
        else if($type == 'minutes') {
            $str = ['минуту', 'минуты', 'минут'];
        }
        else {
            $str = ['секунда', 'секунды', 'секунд'];
        }


        if($digit == 1) {
            return $digit.' '.$str[0].' назад';
        }
        else if($digit >= 2 && $digit <= 4) {
            return $digit.' '.$str[1].' назад';
        }
        else {
            return $digit.' '.$str[2].' назад';
        }
    }

    /**
     * @Route("/handler/cases/price/{id?}", name="cases_main")
     * @param Request $request
     * @param ICasesRepository $casesRepository
     * @return Response
     */
    public function getBasicCasesPrice(Request $request, ICasesRepository $casesRepository)
    {
        $casePrice = [];
        if($request->get('id') == "") {
            $casePrice = [ $casesRepository->find(1)->getPrice(),
                            $casesRepository->find(2)->getPrice()];
        }
        else {
            $casePrice = [ $casesRepository->find($request->get('id'))->getPrice() ];
        }


        header('Content-type: application/json');
        return new Response( json_encode($casePrice) );
    }

    /**
     * @Route("/handler/cases/products/{id}", name="getCases")
     * @param Request $request
     * @param ICasesRepository $casesRepository
     * @param IProductsRepository $productsRepository
     * @return Response
     */
    public function getCasesProducts(Request $request, ICasesRepository $casesRepository, IProductsRepository $productsRepository)
    {
        $products = explode(',',$casesRepository->find($request->get('id'))->getProducts());
        $result = array();
        for($i=0; $i<count($products);$i++)
        {
            $product = $productsRepository->find($products[$i]);
            $newproduct = ['id' => $product->getId(),
                            'name' => $product->getName(),
                            'image_key' => $product->getImageKey(),
                            'price' => $product->getPrice(),
                            'price_sell' => $product->getPriceSell(),
                            'type' => $product -> getType()];
            array_push($result, $newproduct);
        }
        header('Content-type: application/json');
        return new Response( json_encode($result) );
    }

}
