<?php

namespace App\Interfaces;


interface ICasesRepository
{
    public function find($id, $lockMode = null, $lockVersion = null);
    public function findAll();
    public function build ($id);
    public function findCases();
}