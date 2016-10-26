<?php

namespace AppBundle\Entity;

class UserFactory
{
	public function createUser()
    {
        $user = new User();

        $user->setIsManager(false);
        $user->setIsOfficer(false);
        $user->setRegisteredAt(new \DateTime());

        return $user;
    }
	
	public function createAppUser()
    {
        $user = new User();

        $user->setIsApp(true);
		$user->setIsOffice(false);
        $user->setRegisteredAt(new \DateTime());

        return $user;
    }

    public function createOfficeUser()
    {
        $user = new User();

        $user->setIsApp(false);
		$user->setIsOffice(true);
        $user->setRegisteredAt(new \DateTime());

        return $user;
    }
}