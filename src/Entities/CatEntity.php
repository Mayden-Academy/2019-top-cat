<?php

namespace TopCat\Entities;

class CatEntity
{
    private $ID;
    private $image;
    private $breed;

    public function __construct(int $id = 0, string $image = '', int $breed = 0) {
        $this->ID = $id;
        $this->image = $image;
        $this->breed = $breed;
    }

    public function getID() {
        return $this->ID;
    }

    public function getImage() {
        return $this->image;
    }

    public function getBreed() {
        return $this->breed;
    }
}