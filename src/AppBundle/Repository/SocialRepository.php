<?php

namespace AppBundle\Repository;

/**
 * SocialRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SocialRepository extends \Doctrine\ORM\EntityRepository
{
	public function findBySetting($setting){
		return $this->createQueryBuilder('s')
			->where('s.setting = :setting')
				->setParameter('setting', $setting)
			->orderBy('s.socialType', 'ASC')
			->getQuery()
			->getResult();
	}
}
