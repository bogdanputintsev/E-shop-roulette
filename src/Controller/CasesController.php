<?php

namespace App\Controller;

use App\Interfaces\ICasesRepository;
use App\Interfaces\IProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CasesController extends AbstractController
{
    /**
     * @Route("/cases/{id}", name="cases")
     * @param Request $request
     * @param ICasesRepository $casesRepository
     * @param IProductsRepository $productsRepository
     * @return Response
     */
    public function index(Request $request, ICasesRepository $casesRepository, IProductsRepository $productsRepository)
    {
        $case = $casesRepository->find($request->get('id'));
        $game = [];
        $drop_sum = 0;

        if ( $case != null )
        {
            $game = $productsRepository->findProducts($case->getProducts());

            for($i = 0; $i < count($game); $i++){
                $drop_sum += $game[$i]['drop_chance'];
            }
        }

        return $this->render('cases/index.html.twig', [
            'controller_name' => 'CasesController',
            'page' => 'cases',
            'avatar' =>   $this->get('session')->get('avatar'),
            'uid' => 'none' ? $this->get('session')->get('id') == "" : $this->get('session')->get('id'),
            'username' =>  $this->get('session')->get('username'),
            'balance' => $this->get('session')->get('balance'),
            'case_id' => $case->getId(),
            'case_name' => $case->getName(),
            'case_description' => $case->getDescription(),
            'case_price' => $case->getPrice(),
            'game' => $game,
            'game_array_drop_sum' => $drop_sum,
            'game_case' => 'Done' ? count($game) > 0 : 'No'
        ]);
    }


}
