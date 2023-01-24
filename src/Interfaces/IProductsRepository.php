<?php

namespace App\Interfaces;


interface IProductsRepository
{
    public function find($id, $lockMode = null, $lockVersion = null);
    public function findAll();
    public function findProducts($products);
    public function findAllProductsInShop();
    public function findAllAccountsInShop();
    public function findGame($id);

}