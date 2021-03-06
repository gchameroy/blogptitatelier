<?php

namespace AppBundle\Repository;

Use AppBundle\Entity\Post;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends \Doctrine\ORM\EntityRepository
{
	public function findAllNotValidate()
	{
		return $this->createQueryBuilder('c')
			->where('c.isValidate = false')
			->andWhere('c.isDeleted = false')
			->orderBy('c.createdAt', 'ASC')
			->getQuery()->getResult();
	}
	
	public function findAllValidate()
	{
		return $this->createQueryBuilder('c')
			->where('c.isValidate = true')
			->andWhere('c.isDeleted = false')
			->orderBy('c.createdAt', 'ASC')
			->getQuery()->getResult();
	}
	
	public function findAllValidateByPost(Post $post)
	{
		return $this->createQueryBuilder('c')
			->where('c.post = :post')
				->setParameter('post', $post->getId())
			->andWhere('c.isValidate = true')
			->andWhere('c.isDeleted = false')
			->orderBy('c.createdAt', 'ASC')
			->getQuery()->getResult();
	}
}
