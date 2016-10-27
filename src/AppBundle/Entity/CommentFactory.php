<?php

namespace AppBundle\Entity;

class CommentFactory
{
    public function create()
    {
        $comment = new Comment();

        $comment->setIsValidate(false);
        $comment->setIsDeleted(false);
        $comment->setCreatedAt(new \DateTime());

        return $comment;
    }
}