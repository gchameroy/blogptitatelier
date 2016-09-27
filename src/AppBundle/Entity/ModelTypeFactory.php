<?php

namespace AppBundle\Entity;

class ModelTypeFactory
{
    public function create()
    {
        $modelType = new ModelType();

        return $modelType;
    }
}