<?php

namespace App\Controller;

use App\Entity\Users;
use App\Interfaces\IUsersRepository;
use App\Services\AuthService;
use Exception;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    /**
     * @Route("/auth/logout", name="logout")
     */
    public function logout()
    {
        $this->get('session')->clear();
        echo '<script type="text/javascript"> window.location.replace("http://localhost:8000"); </script>';
        exit();
    }

    /**
     * @Route("/auth/vk", name="vk")
     */
    public function vk()
    {
        $session = new Session();
        $session->start();

        echo "Пожалуйста, подождите..";

        $oauth_params = [
            'client_id' => $this->getParameter('client-id'),
            'redirect_uri' => $this->getParameter('redirect'),
            'response_type' => 'code',
            'display' => 'page',
            'scope' => implode(',', $this->getParameter('vk-permissions'))
        ];

        echo '<script type="text/javascript"> window.location.replace("https://oauth.vk.com/authorize?' . http_build_query($oauth_params).'"); </script>';
        exit();
    }

    /**
     * @Route("/auth/vk/parse", name="parse")
     * @param AuthService $authService
     * @param IUsersRepository $usersRepository
     * @return RedirectResponse
     * @throws Exception
     */
    public function parse(AuthService $authService, IUsersRepository $usersRepository)
    {
        $token = $authService->parseToken($this->getParameter('client-id'), $this->getParameter('client-secret'), $_GET['code'], $this->getParameter('redirect'));
        $user = $authService->parseUser($token);

        if(isset($user->response[0]))
        {
            $user = $user->response[0];
            $this->get('session')->set('username', $user->first_name.' '.$user->last_name);
            $this->get('session')->set('avatar', $user->photo_50);

            $account = $usersRepository->findVK($token->user_id);
            if(count($account) == 0)
            {
                $user = new Users();
                $user->setUsername($this->get('session')->get('username'));
                $user->setVkId($this->get('session')->get('id'));
                $user->setRegistrationDate(new \DateTime());
                $user->setLastIP($authService->getIP());
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $this->get('session')->set('id', $user->getId());
                $this->get('session')->set('balance', $user->getBalance());
            }
            else
            {
                $this->get('session')->set('id', $account['id']);
                $this->get('session')->set('balance', $account['balance']);
            }
        }
        return $this->redirect($this->generateUrl('main'));
    }

    /**
     * @Route("/auth/steam", name="steam")
     * @param IUsersRepository $usersRepository
     * @return RedirectResponse
     */
    public function steam(IUsersRepository $usersRepository)
    {
        $session = new Session();
        $session->start();

        echo "Пожалуйста, подождите..";
        $user = $usersRepository->find(1);

        $this->get('session')->set('id', $user->getId());
        $this->get('session')->set('username', $user->getUsername());
        $this->get('session')->set('avatar', "https://thumbs.dreamstime.com/t/error-404-19200592.jpg");
        $this->get('session')->set('balance', $user->getBalance());
        return $this->redirect($this->generateUrl('main'));
    }
}
