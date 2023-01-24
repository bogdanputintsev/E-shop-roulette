<?php

namespace App\Interfaces;


interface IProductsKeysRepository
{
    public function find($id, $lockMode = null, $lockVersion = null);
    public function findAll();
    public function Use(?int $id);
    public function isAvailable($id);
    public function findUnused($game_id);
    public function UseKey($msg);

}