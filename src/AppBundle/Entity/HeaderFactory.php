<?php

namespace AppBundle\Entity;

class HeaderFactory
{
    public function create()
    {
        $header = new Header();

        $header->setInsertedAt(new \DateTime());

        return $header;
    }
}