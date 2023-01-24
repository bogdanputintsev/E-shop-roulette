<?php

namespace App\Controller;

use App\Interfaces\ICasesRepository;
use App\Interfaces\IProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     * @param ICasesRepository $casesRepository
     * @param IProductsRepository $productsRepository
     * @return Response
     */
    public function index(ICasesRepository $casesRepository, IProductsRepository $productsRepository)
    {
        $premium = $casesRepository->find(1);
        $premium_sliced = explode(',', $premium->getProducts());
        $premium_image_keys = array();
        $premium_drop_chance = array();
        $premium_sum = 0;

        for($i = 0; $i < count($premium_sliced); $i++) {
            $product = $productsRepository->find($premium_sliced[$i]);
            array_push($premium_image_keys, $product->getImageKey());
            array_push($premium_drop_chance, $product->getDropChance());
            $premium_sum += $product->getDropChance();
        }


        $vip = $casesRepository->find(2);
        $vip_sliced = explode(',', $vip->getProducts());
        $vip_image_keys = array();
        $vip_drop_chance = array();
        $vip_sum = 0;
        for($i=0; $i<count($vip_sliced); $i++) {
            $product = $productsRepository->find($vip_sliced[$i]);
            array_push($vip_image_keys, $product->getImageKey());
            array_push($vip_drop_chance, $product->getDropChance());
            $vip_sum += $product->getDropChance();
        }

        $cases = $casesRepository->findCases();

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'page' => 'index',
            'avatar' =>   $this->get('session')->get('avatar'),
            'uid' => 'none' ? $this->get('session')->get('id') == "" : $this->get('session')->get('id'),
            'username' =>  $this->get('session')->get('username'),
            'balance' => $this->get('session')->get('balance'),
            'premium_name' => $premium->getName(),
            'premium_description' => $premium->getDescription(),
            'premium_price' => $premium->getPrice(),
            'premium_case' => 'Ready' ? $premium->getProducts() != null : 'No',
            'premium_images' => $premium_image_keys,
            'premium_drop' => $premium_drop_chance,
            'premium_sum' => $premium_sum,
            'vip_name' => $vip->getName(),
            'vip_description' => $vip->getDescription(),
            'vip_price' => $vip->getPrice(),
            'vip_case' => 'Ready' ? $vip->getProducts() != null : 'No',
            'vip_images' => $vip_image_keys,
            'vip_drop' => $vip_drop_chance,
            'vip_sum' => $vip_sum,
            'cases' => $cases,
            'case_state' => "Done" ? count($cases) > 0 : 'No'
        ]);
    }

}
