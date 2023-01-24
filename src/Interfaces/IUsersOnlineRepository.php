<?php

namespace App\Interfaces;


interface IUsersOnlineRepository
{
    public function find($id, $lockMode = null, $lockVersion = null);
    public function findAll();
    public function findMyself($session);
    public function findInactive($time);
    public function findCount($session, $time);

}