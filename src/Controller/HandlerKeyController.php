<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Interfaces\IOrdersRepository;
use App\Interfaces\IProductsKeysRepository;
use App\Interfaces\IUsersRepository;
use App\Services\TakeKeyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HandlerKeyController extends AbstractController
{
    /**
     * @Route("/handler/key/sell", name="sell")
     * @param IUsersRepository $usersRepository
     * @return Response
     * @throws \Exception
     */
    public function sellKey(IUsersRepository $usersRepository)
    {
        $newBalance = intval($_POST['ubalance']) + intval($_POST['income']);
        $real = $usersRepository->find($_POST['uid'])->getId();
        $realBalance = $real - intval($_POST['case_price']);
        if ( $realBalance < 0 ){
            $realBalance = 0;
        }
        $costs = $real - $realBalance;

        $usersRepository->updateBalance($_POST['uid'], $newBalance, $realBalance);

        // Bohuzel, to nejde udelat v datove vrstve. QueryBuilder neumi INSERT, protoze musi pracovat s objektem entity
        // viz https://stackoverflow.com/questions/15619054/is-there-possible-to-use-createquerybuilder-for-insert-update-if-not-what-func
        $order = new Orders();
        $order->setUserId($_POST['uid']);
        $order->setProductId($_POST['result']);
        $order->setCaseId($_POST['case_id']);
        $order->setInfo('Продажа ключа ('.$_POST['price_sell'].' рублей)');
        $order->setDate(new \DateTime());
        $order->setPrice(intval($_POST['case_price']));
        $order->setCosts($costs);
        $order->setShowInTape(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($order);
        $em->flush();

        return new Response("[Продажа ключа]: Успех");
    }

    /**
     * @Route("/handler/key/take", name="take")
     * @param TakeKeyService $takeKeyService
     * @param IOrdersRepository $ordersRepository
     * @param IUsersRepository $usersRepository
     * @param IProductsKeysRepository $productsKeysRepository
     * @return Response
     */
    public function takeKey(TakeKeyService $takeKeyService, IOrdersRepository $ordersRepository, IUsersRepository $usersRepository, IProductsKeysRepository $productsKeysRepository)
    {
        $msg = "";
        if($_GET['keytype'] == "twokeys")
        {
            $msg = $takeKeyService->FindTwoKeys($ordersRepository,$usersRepository, $productsKeysRepository);
        }
        else
        {
            $msg = $takeKeyService->FindKey($ordersRepository, $usersRepository, $productsKeysRepository);
        }

        if ( $msg == "[Выдача ключа]: Ключ не был найден" ){
            return new Response($msg);
        }

        $ordersRepository->takeKey($msg, $ordersRepository->lastID($_GET['uid']));

        $difference = $_GET['ubalance'] - $_GET['price_sell'];
        $usersRepository->update($_GET['uid'], $difference);
        $productsKeysRepository->UseKey($msg);
        return new Response( "[Выдача ключа]: Успех");

    }
}
