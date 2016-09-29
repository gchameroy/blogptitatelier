<?php

namespace AppBundle\Entity;

class SocialFactory
{
    public function create()
    {
        $social = new Social();

        return $social;
    }
}