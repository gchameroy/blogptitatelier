<?php

namespace AppBundle\Entity;

class ModelFactory
{
    public function create()
    {
        $model = new Model();

        return $model;
    }
}