<?php

namespace AppBundle\Repository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{
	public function findRecents()
	{
		$now = new \DateTime();
		return $this->createQueryBuilder('p')
			->where('p.publishedAt IS NOT NULL')
			->andWhere('p.publishedAt <= :now')
				->setParameter('now', $now->format('Y-m-d H:i:s'))
			->orderBy('p.publishedAt', 'DESC')
			->addOrderBy('p.id', 'DESC')
			->setMaxResults(4)
			->getQuery()->getResult();
	}
	
	public function findByPage($page = 1, $maxResults = 10)
	{
		$maxResults = 10;
		$first = ($page - 1) * $maxResults;
		
		$now = new \DateTime();

		return $this->createQueryBuilder('p')
			->where('p.publishedAt <= :now')
				->setParameter('now', $now->format('Y-m-d H:i:s'))
			->orderBy('p.publishedAt', 'DESC')
			->addOrderBy('p.id', 'DESC')
			// ->setFirstResult($first)
			// ->setMaxResults($maxResults)
			->getQuery()->getResult();
	}
	
	public function findByCategory($categoryId, $page = 1, $maxResults = 10)
	{
		$maxResults = 10;
		$first = ($page - 1) * $maxResults;
		
		$now = new \DateTime();

		return $this->createQueryBuilder('p')
			->where('p.publishedAt <= :now')
				->setParameter('now', $now->format('Y-m-d H:i:s'))
			->andWhere('p.categoryId = :categoryId')
				->setParameter('categoryId', $categoryId)
			->orderBy('p.publishedAt', 'DESC')
			->addOrderBy('p.id', 'DESC')
			// ->setFirstResult($first)
			// ->setMaxResults($maxResults)
			->getQuery()->getResult();
	}
}
