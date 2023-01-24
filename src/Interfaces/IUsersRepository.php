<?php

namespace App\Interfaces;


interface IUsersRepository
{
    public function find($id, $lockMode = null, $lockVersion = null);
    public function findAll();
    public function getUser($id);
    public function updateBalance ($id, $balance, $realBalance);
    public function update ($uid, $difference);
    public function useDailyGift($id);
    public function findVK($id);
}