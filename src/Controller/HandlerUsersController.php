<?php

namespace App\Controller;

use App\Entity\UsersOnline;
use App\Interfaces\IUsersOnlineRepository;
use App\Interfaces\IUsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HandlerUsersController extends AbstractController
{
    /**
     * @Route("/handler/users", name="users")
     * @param IUsersRepository $usersRepository
     * @return Response
     */
    public function users(IUsersRepository $usersRepository)
    {
        $user = [];

        if ( $this->get('session')->get('id') != "" )
        {
            $user = $usersRepository->getUser($this->get('session')->get('id'))[0];
        }

        header('Content-type: application/json');
        return new Response( json_encode( $user ) );
    }

    /**
     * @Route("/handler/users/pay", name="pay")
     * @param IUsersRepository $usersRepository
     * @return Response
     */
    public function pay(IUsersRepository $usersRepository)
    {
        $user = $usersRepository->find(1);
        $user->setBalance($user->getBalance() + 50);
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return new Response( "Success");
    }

    /**
     * @Route("/handler/users/online", name="online")
     * @param IUsersOnlineRepository $usersOnlineRepository
     * @return int|mixed
     */
    public function online(IUsersOnlineRepository $usersOnlineRepository)
    {
        $session = session_id();
        $time = time();

        if ($usersOnlineRepository->findMyself($session) == false )
        {
            $newUser = new UsersOnline();
            $newUser->setSession($session);
            $newUser->setTime($time);
            $em = $this->getDoctrine()->getManager();
            $em->persist($newUser);
            $em->flush();
        }

        return new Response($usersOnlineRepository->findCount($session, $time));
    }

    /**
     * @Route("/handler/users/balance", name="balance")
     * @param IUsersRepository $usersRepository
     * @return Response
     */
    public function balance(IUsersRepository $usersRepository)
    {
        $balance = 0;
        if($this->get('session')->get('id')!= "") {
            $balance = $usersRepository->find(array('id' => $this->get('session')->get('id')))->getBalance();
        }

        return new Response( "Баланс: " . $balance);
    }
}
