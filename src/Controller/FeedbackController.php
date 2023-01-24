<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackController extends AbstractController
{
    /**
     * @Route("/feedback", name="feedback")
     */
    public function index()
    {
        return $this->render('feedback/index.html.twig', [
            'controller_name' => 'FeedbackController',
            'page' => 'feedback',
            'avatar' =>   $this->get('session')->get('avatar'),
            'uid' => 'none' ? $this->get('session')->get('id') == "" : $this->get('session')->get('id'),
            'username' =>  $this->get('session')->get('username'),
            'balance' => $this->get('session')->get('balance')
        ]);
    }
}
