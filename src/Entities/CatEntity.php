<?php

namespace TopCat\Entities;

class CatEntity
{
    private $id;
    private $image;
    private $breed;

    public function getID()
    {
        return $this->id;
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