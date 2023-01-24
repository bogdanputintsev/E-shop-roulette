<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RedirectController extends AbstractController
{
    /**
     * @Route("/redirect/pay", name="paymentlink")
     */
    public function pay()
    {
        return new Response("There will be a platform for payment.");
    }

    /**
     * @Route("/redirect/community", name="community")
     */
    public function community()
    {
        return new Response("There will be a community in a social media in a future.");
    }


}
