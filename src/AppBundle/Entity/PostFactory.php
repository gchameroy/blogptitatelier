<?php

namespace AppBundle\Entity;

class PostFactory
{
    public function create()
    {
        $post = new Post();
		
		$post->setTitle('Nouvel Article');
		$post->setImage('default.jpg');
		$post->setContent('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ac tempor ipsum. Quisque tristique pretium dignissim. Mauris dapibus dictum neque vel imperdiet. Aliquam sit amet enim dapibus, placerat dolor in, semper risus. In eleifend, mi in pretium consectetur, nisl turpis lobortis nibh, sit amet pharetra elit ligula ac velit. Sed mattis mattis nunc, sodales vehicula eros cursus a. Etiam malesuada, leo at tincidunt varius, mi mauris condimentum elit, sed euismod nisl eros vitae lacus. Pellentesque at odio vehicula, sollicitudin quam vitae, egestas nisi. Cras maximus mauris sed tellus consectetur convallis.</p>');

        $post->setInsertedAt(new \DateTime());
        $post->setUpdatedAt(new \DateTime());

        return $post;
    }
}