<?php

namespace App\Controller;

use App\Interfaces\IUsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HandlerBonusesController extends AbstractController
{
    /**
     * @Route("/handler/bonuses/feedback/", name="feedbackhandler")
     * @param IUsersRepository $usersRepository
     * @return Response
     */
    public function feedbackFind(IUsersRepository $usersRepository)
    {
        if($usersRepository->find($_GET['uid'])->getWroteFeedback() == true){
            return new Response("[Отзывы]: Уже использовано");
        }
        return new Response("[Отзывы]: Не обнаружено");
    }
    /**
     * @Route("/handler/bonuses/stop/{id}", name="stop")
     * @param Request $request
     * @param IUsersRepository $usersRepository
     * @return Response
     */
    public function bonusesStop(Request $request, IUsersRepository $usersRepository)
    {
        $usersRepository->useDailyGift($request->get('id'));
        return new Response(1);
    }
}
