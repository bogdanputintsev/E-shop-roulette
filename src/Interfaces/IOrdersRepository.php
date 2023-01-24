<?php

namespace App\Interfaces;


interface IOrdersRepository
{
    public function find($id, $lockMode = null, $lockVersion = null);
    public function findAll();
    public function winningsCount();
    public function livetape();
    public function takeKey(?string $value, $uid);
    public function findByUser($user_id);
    public function setKey($uid, $msg);
    public function lastID($uid);
}