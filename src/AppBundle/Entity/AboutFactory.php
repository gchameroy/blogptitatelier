<?php

namespace AppBundle\Entity;

class AboutFactory
{
    public function create()
    {
        $about = new About();

        $about->setInsertedAt(new \DateTime());

        return $about;
    }
}