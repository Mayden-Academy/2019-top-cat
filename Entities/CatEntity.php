<?php

namespace entities;

class CatEntity
{
    private $id;
    private $image;
    private $breed;

    public function __construct($id, $image, $breed)
    {
        $this->id = $id;
        $this->image = $image;
        $this->breed = $breed;
    }

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