<?php

namespace AppBundle\Entity;

class PostLikeFactory
{
    public function create()
    {
        $postLike = new PostLike();
		
        $postLike->setLikeAt(new \DateTime());

        return $postLike;
    }
}