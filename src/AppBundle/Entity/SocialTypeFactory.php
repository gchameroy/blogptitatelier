<?php

namespace AppBundle\Entity;

class SocialTypeFactory
{
    public function create()
    {
        $socialType = new SocialType();

        return $socialType;
    }
}