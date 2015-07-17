<?php
// src/Blogger/BlogBundle/Entity/Settings.php

namespace Blogger\BlogBundle\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;


class Settings
{
    protected $inhoud;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('inhoud', new NotBlank());
    }

    public function getInhoud()
    {
        return $this->inhoud;
    }

    public function setInhoud($inhoud)
    {
        $this->inhoud = $inhoud;
    }

}