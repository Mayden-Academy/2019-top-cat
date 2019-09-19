<?php

namespace TopCat\Entities;

class CatEntity
{
    private $ID;
    private $image;
    private $breed;

    public function getID()
    {
        return $this->ID;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getBreed()
    {
        return $this->breed;
    }
}