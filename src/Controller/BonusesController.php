<?php

namespace App\Controller;


use App\Interfaces\ICasesRepository;
use App\Interfaces\IProductsRepository;
use App\Interfaces\IUsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BonusesController extends AbstractController
{
    /**
     * @Route("/bonuses", name="bonuses")
     * @param IUsersRepository $usersRepository
     * @param ICasesRepository $casesRepository
     * @param IProductsRepository $productsRepository
     * @return Response
     */
    public function index(IUsersRepository $usersRepository, ICasesRepository $casesRepository, IProductsRepository $productsRepository)
    {
        $case = $casesRepository->find(3);
        $game = [];
        $drop_sum = 0;
        $gift = false;

        if ( $this->get('session')->get('id') != "" ) {
            $gift = $usersRepository->find($this->get('session')->get('id'))->getDailyGift();
        }

        if ( $case != null )
        {
            $game = $productsRepository->findProducts($case->getProducts());
            for($i = 0; $i < count($game); $i++){
                $drop_sum += $game[$i]['drop_chance'];
            }
        }

        return $this->render('bonuses/index.html.twig', [
            'controller_name' => 'BonusesController',
            'page' => 'bonuses',
            'avatar' =>   $this->get('session')->get('avatar'),
            'uid' => 'none' ? $this->get('session')->get('id') == "" : $this->get('session')->get('id'),
            'username' =>  $this->get('session')->get('username'),
            'balance' => $this->get('session')->get('balance'),
            'gift' => $gift,
            'case_id' => 3,
            'game' => $game,
            'game_array_drop_sum' => $drop_sum,
            'game_case' => 'Done' ? count($game) > 0 : 'No'
        ]);
    }
}
