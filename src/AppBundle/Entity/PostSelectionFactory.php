<?php

namespace AppBundle\Entity;

class PostSelectionFactory
{
    public function create()
    {
        $postSelection = new PostSelection();
		
		$postSelection->setIsActive(true);
        $postSelection->setInsertedAt(new \DateTime());

        return $postSelection;
    }
}