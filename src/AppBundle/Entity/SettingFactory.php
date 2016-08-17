<?php

namespace AppBundle\Entity;

class SettingFactory
{
    public function create()
    {
        $setting = new Setting();

        $setting->setUpdatedAt(new \DateTime());

        return $setting;
    }
}