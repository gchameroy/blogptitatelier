<?php

namespace AppBundle\Entity;

class CategoryFactory
{
    public function create()
    {
        $category = new Category();

        $category->setIsHidden(false);
        $category->setUpdatedAt(new \DateTime());

        return $category;
    }
}