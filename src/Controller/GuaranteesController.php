<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GuaranteesController extends AbstractController
{
    /**
     * @Route("/guarantees", name="guarantees")
     */
    public function index()
    {
        return $this->render('guarantees/index.html.twig', [
            'controller_name' => 'GuaranteesController',
            'page' => 'guarantees',
            'avatar' =>   $this->get('session')->get('avatar'),
            'uid' => 'none' ? $this->get('session')->get('id') == "" : $this->get('session')->get('id'),
            'username' =>  $this->get('session')->get('username'),
            'balance' => $this->get('session')->get('balance')
        ]);
    }
}
